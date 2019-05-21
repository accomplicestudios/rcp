<?php 

class Home extends MB_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('homepages_model');
	}

	function index() {

		$id = 0; 

		if ($this->is_on_preview()) {

			$id = $this->input->get('id'); 
		}
		else {

			if ($record = $this->homepages_model->get_primary()) {

				$id = $record->id;
			} 
		}

		if ($record = $this->homepages_model->get($id)) {

			!strstr($record->link, 'http') && $record->link = 'http://' . $record->link; 
			$this->data['homepage'] = $record; 

			$bg_css = []; 
			$bg_css[] = "background-image: url('" . _cdn("/assets/" . $record->background_image) . "');";
			!empty($record->background_color) && $bg_css[] = 'background-color: ' . $record->background_color . ';'; 

			$this->data['bg_css'] = implode(' ', $bg_css);

			$this->data['logo'] = 'RCP_Logo_' . ($record->logo_color === 'black' ? 'Blk' : 'Wht') . '.svg';
			$this->view('home');
		}
		else {

			show_404();
		}

	}
}