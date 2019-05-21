<?php

class Homepages_model extends CI_Model {

    const TBL = "homepages"; 

    function get($id) {

        $ret = NULL; 

        $this->db->where('id', $id);

        if ($q = $this->db->get(static::TBL)) {

            if ($r = $q->row()) {

                $ret = $r; 
            }

            $q->free_result();
        }

        return $ret; 
    }

    function get_primary() {

        $ret = NULL; 

        $this->db->where('is_primary', 1); 

        if ($q = $this->db->get(static::TBL)) {

            if ($r = $q->row()) {

                $ret = $r; 
            }

            $q->free_result();
        }

        return $ret;         

    }

}