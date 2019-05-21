<?php 

class Contact extends MY_Controller {
	
	protected $default_url = '/contact';
	protected $tbl = 'contact';

	function index() {

        $id = 1; 
		$options = new stdClass;

		$options->redirect_url = NULL;
		$options->force_redirect = 0;
		$options->tbl = $this->tbl;
		
		$options->maps = array(
			array('label' => 'Phone', 'db'=>'phone'),
			array('label' => 'E-mail', 'db'=>'email'),
			array('label' => 'Street Address', 'db'=>'street'),
			array('label' => 'City, State, Zip', 'db'=>'city'),
			array('label' => 'Google Maps URL', 'db'=> 'googlemaps')
        );
		
		$options->id = (object) ['val' => $id];
				
		$this->_edit($options);
	}

}