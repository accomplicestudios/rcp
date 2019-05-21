<?php 

class Login extends CI_Controller {
	
	function index() {
	
		form_rules(
			array(
				array('username', 'Username'),
				array('password', 'Password')
			)
		);
	
		if ($this->form_validation->run() !== FALSE) {

			$this->db->where('login_name', $this->input->post('username'));
			$this->db->where('login_pwd', $this->input->post('password'));
			
			$q = $this->db->get('accounts');

			if ($q->num_rows()) {
				
				$this->session->set_userdata('logged_in', TRUE);
				redirect('/home');exit;
			}
			
			var_dump('error');exit; 
		}
		
		$this->load->view('login');
	}
	
	
}