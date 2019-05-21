<?php 

class Artists extends MB_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model(['artists_model', 'artist_photos_model','exhibitions_model']);
		$this->data['records'] = $this->artists_model->get_all();
	}

	function index() {

		$this->view('artists/index');
	}

	function profile($slug) {

		if ($r = $this->artists_model->get_by_slug($slug, $this->is_on_preview())) {

			$this->data['record'] = $r; 

			$this->data['record']->gallery = []; 

			if ($photos = $this->artist_photos_model->get_by_artist($r->id)) {

				foreach($photos as $p) {

					$item = (object)[
						'choices' => ['default' => $p->filename], 
						'info' => $p->description
					];

					$this->data['record']->gallery[] = $item;
				}
			}

			$this->data['record']->exhibitions = $this->exhibitions_model->get_by_artist($r->id);
			$this->data['exhibition_show_artist_name'] = FALSE; 
		}

		if (!empty($this->data['record'])) {

			$this->view('artists/profile');
		}
		else {

			show_404();
		}
	}
}