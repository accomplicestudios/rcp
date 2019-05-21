<?php 

class Slides extends MY_Controller {
	
	protected $default_url = '/slides/list';
	protected $tbl = 'slides';
	

	function index() {

		redirect($this->default_url);exit;
	}

	function list_($filter_code = FALSE) {
		
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Name', 'width'=> '40%', 'url'=> "{$this->default_url}/edit/[id]", 'map' => 'name'),
			(object)array('cls'=>'gtitle', 'label'=>'Type', 'width'=> '10%', 'map' => 'type_code', 'formatter' => 'ucwords'),
			(object)array('cls'=>'gactions', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x'), 
			(object)array('cls'=>'gactions', 'ecls' => 'single_image', 'width'=> '20%',  'url'=> "/assets/[image1]", 'title' => 'view photo')
			
		);
		
		$this->data['category'] = (object)array('name' => 'View All Slides');

		if (!empty($filter_code)) {
			
			if (in_array($filter_code, array('text', 'photo', 'calendar'))) {
				
				$this->db->where('type_code', $filter_code);
			}
			else if ($filter_code == 'featured') {
				
				$this->db->where('featured', 1);
			}
			
			$this->data['category'] = (object)array('name' => ucwords($filter_code));
		}
		
		$this->db->order_by('seq asc');
		$this->data['listQ'] = $this->db->get($this->tbl);
		
		$this->_list();
	}
	
	
	function add_text() {

		$options = new stdClass;

		$options->tbl = $this->tbl ;
		$options->redirect_url = $this->default_url;

		$options->maps = array(

			array('label' => 'Name', 'db'=>'name'),
			array('label' => 'Text', 'db'=>'description', 'type' => 'textarea', 'rules' => 'trim|required'),
			array('label' => 'Type', 'db'=>'type_code', 'type' => 'hidden', 'rules' => 'trim|required', 'def'=> 'text')
		);
		
		$this->data['category'] = (object) array('name' => 'New Text Slide');
		$this->_add($options);
	}

	function add_photo() {

		$options = new stdClass;

		$options->tbl = $this->tbl ;
		$options->redirect_url = $this->default_url;

		$options->maps = array(

			array('label' => 'Name', 'db'=>'name'),
			array('label' => 'Photo*', 'db'=>'image1', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'image1_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'image1'),

			array('label' => 'Type', 'db'=>'type_code', 'type' => 'hidden', 'rules' => 'trim|required', 'def'=> 'photo')
		);
		
		$this->data['category'] = (object) array('name' => 'New Photo Slide');
		$this->_add($options);		
	}
	

	
	function edit_text($id) {

		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0;
		$options->tbl = $this->tbl;

		$options->maps = array(
			array('label' => 'Name', 'db'=>'name'),
			array('label' => 'Text', 'db'=>'description', 'type' => 'textarea', 'rules' => 'trim|required'),
		);

		
		$options->id = (object) ['val' => $id];
		$this->data['category'] = (object) array('name' => 'Edit Text Slide > ' . $this->_name('slides', $id, 'name'));
				
		$this->_edit($options);
	}
	
	function edit_photo($id) {


		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0;
		$options->tbl = $this->tbl;

		$options->maps = array(
			array('label' => 'Name', 'db'=>'name'),
			array('label' => 'Photo', 'db'=>'image1', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'image1_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'image1')
		);

		
		$options->id = (object) ['val' => $id];
		$this->data['category'] = (object) array('name' => 'Edit Photo Slide > ' . $this->_name('slides', $id, 'name'));
				
		$this->_edit($options);
				
	}
	


	function edit_($id) {

		$this->db->where('id', $id);
		
		if ($q = $this->db->get($this->tbl)) {
			
			if ($r = $q->row()) {
				
				redirect(strtolower(__CLASS__) . '/edit_' . $r->type_code . '/' . $id);
				exit;
			}
		}
		
		show_404();
	}
	



	function delete_($id) {

		$options = new stdClass;
		$options->id = (object) ['val' => $id];
		$options->redirect_url = $this->default_url;
		$options->tbl = $this->tbl;
		$this->_delete($options);
	}

	function sort() {
		
		$options = new stdClass;

		$options->tbl = $this->tbl ;
		$options->order_by = 'seq'; 
		$options->redirect_url = $this->default_url;
		
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Name', 'width'=> '40%', 'map' => 'name'),

		);

		$this->data['category'] = (object)array('name' => 'Re-order List');


	
		$this->_sort($options);
	}
}