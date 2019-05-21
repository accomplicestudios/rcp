<?php 

class Exhibition_installation_photos_model extends CI_Model {

    const TBL = 'exhibition_installation_photos';

    function get($id) {

    }

    function get_by_exhibition($exhibition_id) {

        $ret = []; 

        $this->db->where('exhibition_id', $exhibition_id); 
        $this->db->order_by('position', 'asc');

        if ($q = $this->db->get(static::TBL)) {

            foreach($q->result_object() as $r) {

                $ret[] = $r; 
            }

            $q->free_result();
        }

        return $ret; 
    }
}