<?php

class Info_model extends CI_Model {
	
	function get($name) {
		
		$ret = ''; 
		
		$this->db->where('code', $name);
		
		if ($q = $this->db->get('overviews')) {
			
			if ($q->num_rows()) {
				
				$r = $q->row();
				
				$ret = $r->description;
			}

			$q->free_result();
		}

		return $ret; 
	}
}