<?php 

class Artist_photos_model extends CI_Model {

    const TBL ='artist_photos'; 

    function get_by_artist($artist_id) {
        
        $ret = []; 

        $this->db->where('artist_id', $artist_id);
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