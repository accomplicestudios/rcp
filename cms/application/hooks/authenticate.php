<?php

function validate_session() {

	$c =& get_instance();
	$r =& load_class('Router');

	$ignore_list = array('login', 'logout');

	if ( ! in_array(strtolower($r->fetch_class()), $ignore_list) ) {
		
		if (empty($c->session->userdata('logged_in'))) {

			redirect('/login');exit;
		}
	}
	
	return TRUE;
}
