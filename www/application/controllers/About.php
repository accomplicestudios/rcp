<?php 

class About extends MB_Controller {

	function index() {

		$this->data['has_footer'] = FALSE;
		$this->data['page_css'] = 'about page-dark';
		$this->data['logo'] = 'Logo_W_256p.png';

		foreach(['tagline', 'hours', 'public_transportation', 'parking', 'disclaimer'] as $code) {

			$this->data[$code] = $this->overviews_model->get($code); 
		}

		$this->view('about');
	}
}