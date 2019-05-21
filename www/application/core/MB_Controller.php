<?php 

class MB_Controller extends CI_Controller {

	protected $data = array(
		'has_footer' => TRUE, 
		'page_css' => NULL, 
		'logo' => 'RCP_Logo_Blk.svg', 
		'current' => NULL,  
		'bg_css' => ''
	); 

	function __construct() {

		parent::__construct();
		$this->data['current'] = strtolower(get_class($this));
		$this->data['page_css'] = strtolower(get_class($this));
		$this->data['contact'] = @$this->db->get('contact')->row();
		$this->data['sociables'] = @$this->db->get('sociables')->row();
	}

	function view($view_file) {

		if (strstr($this->data['page_css'], 'dark')) {

			$this->data['logo'] = "RCP_Logo_Wht.svg";
		}

		$this->load->view('_header', $this->data);
		$this->load->view($view_file, $this->data);
		$this->load->view('_footer', $this->data);
	}
	
	function is_on_preview() {

		if ($this->input->get('preview') == 1) {

			if (TRUE == $this->session->userdata('logged_in')) {

				return TRUE; 
			}
			else {

				show_error('Unauthorized preview mode, kindly login to CMS first.');
			}
		}

		return FALSE; 
	}
}