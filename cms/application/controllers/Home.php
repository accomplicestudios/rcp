<?php 

class Home extends MY_Controller {
	
	function index() {
		
		redirect('/homepage');
	}
	
	
	//function index() {
	//	
	//	$this->data['navs'] = $this->navs_model->roster();
	//	
	//	$this->load->view('_header', $this->data);
	//	$this->load->view('home', $this->data);
	//	$this->load->view('_footer');
	//}
	//
	//function pop() {
	//	
	//	$this->db->query('TRUNCATE table sections;');
	//	$this->db->query('TRUNCATE table categories;');
	//
	//	$this->load->config('jf');
	//	$this->data['navs'] = $this->config->item('navs');
	//	
	//	foreach($this->data['navs'] as $key=>$val) {
	//		
	//		$section = array(
	//			'name' => ucwords($val[0]),
	//			'url' => url_title($key, 'underscore') 
	//		);
	//		
	//		$this->db->insert('sections', $section);
	//		$section_id = $this->db->insert_id();
	//		
	//		if (!empty($val['links'])) {
	//			foreach($val['links'] as $key2=>$val2) {
	//				
	//				$link = array(
	//					'name'=> ucwords($key2),
	//					'url' => $val2,
	//					'section_id' => $section_id
	//				);
	//				
	//				$this->db->insert('categories', $link);
	//			}
	//		}
	//	}
	//}
}
