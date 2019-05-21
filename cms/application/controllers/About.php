<?php 

class About extends MY_Controller {
	
	protected $default_url = '/about';
	protected $tbl = 'overviews';
	const PHOTO_RECORD_ID = 45; 
	

	function index() {

		redirect('/about/tagline');exit;
	}

	function tagline() {

		$this->data['category'] = (object) array('name' => 'Tagline');
		$this->_overview('tagline');
	}

	function hours() {

		$this->data['category'] = (object) array('name' => 'Hours');
		$this->_overview('hours');
	}

	function public_transportation() {

		$this->data['category'] = (object) array('name' => 'Public Transporation');
		$this->_overview('public_transportation');
	}

	function parking() {

		$this->data['category'] = (object) array('name' => 'Parking');
		$this->_overview('parking');
	}

	function photo() {
		
		$options = new stdClass;

		$options->redirect_url = NULL; //$this->default_url;
		$options->force_redirect = 0;
		$options->tbl = $this->tbl;

		$options->maps = array(
			array('label' => 'Photo', 'db'=>'photo', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'photo_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'photo'), 
			array('label' => 'Disclaimer', 'db'=>'description', 'rules' => 'trim')
		);
		
		$options->id = (object)['val' => static::PHOTO_RECORD_ID];
		$this->data['category'] = (object) array('name' => 'Photo &amp; Disclaimer');
				
		$this->_edit($options);
	}
}