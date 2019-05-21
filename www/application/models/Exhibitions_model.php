<?php 

class Exhibitions_model extends CI_Model {

    const TBL = 'exhibitions'; 
    const TBL_PHOTOS = 'exhibition_photos'; 

    protected $_roster; 


    function __construct() {

        parent::__construct();
    }

    function get_by_artist($artist_id) {

		$ret = []; 

		$this->db->select('e.*, a.first_name, a.last_name');
        $this->db->join('artists a', 'a.id = e.artist_id');
        
		$this->db->where('e.artist_id', $artist_id);
		$this->db->where('e.is_published', 1); 

		$this->db->order_by('e.date_start', 'desc');

		if ($q = $this->db->get(static::TBL . ' e')) {

			foreach($q->result_object() as $r) {

                $ret[] = $this->_morph($r); 
			}

			$q->free_result();
		}

        return $ret; 
	}

	
    function get_by_date($filter_code) {

        $ret = []; 

        $this->db->order_by('e.date_start', 'asc');

        if ($filter_code == 'past') {

            $this->db->where('e.date_end < curdate()');
            $this->db->order_by('e.date_start desc'); 
        }
        else if ($filter_code == 'current') {

            $this->db->where('e.date_start <= curdate() and e.date_end >= curdate()');
        }
        else if ($filter_code == 'upcoming') {

            $this->db->where('e.date_start > curdate()');
        }

        $this->db->where('e.is_published', 1);

		$this->db->select('e.*, a.first_name, a.last_name');
        $this->db->join('artists a', 'a.id = e.artist_id');

		if ($q = $this->db->get(static::TBL . ' e')) {

            foreach($q->result_object() as $r) {

                $ret[] = $this->_morph($r);
            }

            $q->free_result();
        }

        return $filter_code == 'current' ? current($ret) : $ret; 
    }


    protected function _morph($r) {

        $record = $r;

		$record->list_image = [
            'default' => $r->list_image
        ]; 
    
		return $record; 
    }

    function get_by_slug($slug) {

        $ret = NULL; 

        $slug = strtolower($slug);
        $this->db->where('e.slug', $slug);

        $this->db->select('e.*, a.first_name, a.last_name');
        $this->db->join('artists a', 'a.id = e.artist_id');

        if ($q = $this->db->get(static::TBL . ' e')) {

            if ($r = $q->row()) {

                $ret = $this->_morph($r);
            }

            $q->free_result();
        }

        return $ret; 
    }

}