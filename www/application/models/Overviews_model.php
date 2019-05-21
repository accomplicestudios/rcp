<?php 

class Overviews_model extends CI_Model {

    protected $tbl = 'overviews'; 

    function get($code) {

        $ret = NULL;

        if ($q = $this->db->get_where($this->tbl, ['code' => $code])) {

            if ($q->num_rows()) {

                $ret = $q->row(); 
            }

            $q->free_result();
        }

        return $ret; 
    }
}