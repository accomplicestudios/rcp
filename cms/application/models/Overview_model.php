<?php

class Overview_model extends CI_Model {
	
	public $code, $id, $photo, $short_description, $description, $date_modified;
	private $tbl = 'overviews';

	function __construct() {
		
		parent::__construct();
	}
	
	function get($code) {
		
		$q = $this->db->get_where($this->tbl, array('code' => $code));
		
		if ($q->num_rows() === 0) {

			$this->code = $code;
			$this->description = '';
			
			$this->save(TRUE);
			
			$q = $this->db->get_where($this->tbl, array('code' => $code));
		}
		
		$r = $q->row();

		$this->id = $r->id;
		$this->code = $r->code;
		$this->short_description = $r->short_description;
		$this->photo = $r->photo;
		$this->description = $r->description;
		$this->date_modified = $r->date_modified;
	}
	
	function save($insert = FALSE) {
		
		if ($insert) {


			return $this->db->insert($this->tbl, array('code'=> $this->code, 'description'=>$this->description));
		}
		else {

			$this->db->where('code', $this->code);
			return $this->db->update($this->tbl, array('description' => $this->description));
		}
	}
}