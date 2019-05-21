<?php 

class Exhibitions extends MB_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model(['exhibitions_model', 'exhibition_photos_model', 'exhibition_installation_photos_model']);
	}

	function _setup_roster() {

		$ret = []; 

		$this->db->where('is_published', 1); 
		$this->db->order_by('date_start', 'desc');

		if ($q = $this->db->get('exhibitions')) {

			foreach($q->result_object() as $r) {

				$ret[] = $this->_morph($r); 
			}

			$q->free_result();
		}

		return $ret; 
	}


	protected function _get_exhibit($slug) {

		$ret = NULL; 
		$previous = NULL; 
		$next = NULL; 

		$roster_count = count($this->data['roster']);

		foreach($this->data['roster'] as $k => $exhibit) {

			if ($exhibit->slug === $slug) {

				$ret = $exhibit;

				if ($k > 0) {

					$previous = $this->data['roster'][$k-1];
				} 
				else {
					$previous = $this->data['roster'][$roster_count - 1]; 
				} 

				if ($k == ($roster_count - 1)) {

					$next = $this->data['roster'][0]; 
				}
				else {

					$next = $this->data['roster'][$k+1];
				}

				$exhibit->previous = $previous; 
				$exhibit->next = $next; 

				break;
			}
		}

		return $ret;
	}

	function index() {

		$this->data['current_item'] = $this->exhibitions_model->get_by_date('current'); 
		$this->data['upcoming_items'] = $this->exhibitions_model->get_by_date('upcoming'); 
		$this->data['past_items'] = $this->exhibitions_model->get_by_date('past'); 

		$this->data['exhibition_show_artist_name'] = TRUE; 

		$this->view('exhibitions/index');
	}

	function profile($slug = '') {

		$this->data['page_css'] .= ' page-dark';

		if ($this->data['record'] = $this->exhibitions_model->get_by_slug($slug)) {

			$record =& $this->data['record'];

			$record->gallery = []; 

			if ($photos = $this->exhibition_photos_model->get_by_exhibition($this->data['record']->id)) {

				foreach($photos as $p) {

					$item = (object)[
						'choices' => ['default' => $p->filename], 
						'info' => $p->description
					];

					$record->gallery[] = $item;
				}
			}

			// $record->gallery = array_slice($record->gallery, 1, 1);

			$record->installations = []; 

			if ($photos = $this->exhibition_installation_photos_model->get_by_exhibition($this->data['record']->id)) {

				foreach($photos as $p) {

					$item = (object)[
						'choices' => ['default' => $p->filename], 
						'info' => $p->description
					];

					$record->installations[] = $item;
				}
			}

			$this->view('exhibitions/profile');
		}
		else {
			
			show_404();
		}
	}


}