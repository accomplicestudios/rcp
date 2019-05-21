<?php 

class Sociables extends MY_Controller {
	
	protected $default_url = '/sociables';
	protected $tbl = 'sociables';

	function index() {

        $id = 1; 
		$options = new stdClass;

		$options->redirect_url = NULL;
		$options->force_redirect = 0;
		$options->tbl = $this->tbl;
		
		$options->maps = array(
			array('label' => 'Instagram', 'db'=>'instagram'),
			array('label' => 'Facebook', 'db'=>'facebook'),
			array('label' => 'Subscribe', 'db'=>'subscribe')
        );
		
		$options->id = (object)['val' => $id];
				
		$this->_edit($options);
	}

}