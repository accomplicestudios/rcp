<?php

class Navs_model extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	function roster() {
		
		$this->db->order_by('seq', 'asc');
		return $this->db->get('sections');
	}
	
	function section($id) {
		
		$where = NULL;
		
		if (is_numeric($id)) {
			$where = array('id' => $id);
		}
		else {
			$where = array('url' => $id);
		}
		
		$q =  $this->db->get_where('sections', $where);
		return $q->row();
	}
	
	function section_uri($uri) {
		
		$q = $this->db->get_where('sections', array('url'=> $uri));
		return $q->row();
	}
	
	
	function cats($id) {
		
		$where = array('section_id' => $id);
		$this->db->order_by('seq', 'asc');
		return $this->db->get_where('categories', $where);
	}
	
	function category_uri($uri, $section_id) {
		
		$q = $this->db->get_where('categories', array('section_id' => $section_id, 'url' => $uri));
		return $q->row();
	}
}