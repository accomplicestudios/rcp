<?php 

class News extends MB_Controller {

	function index() {

		$this->data['records'] = []; 

		$this->db->select("a.title, 
		a.subtitle, 
		a.link_name, 
		a.link_url, 
		concat(b.first_name, ' ', b.last_name) as artist_name"); 

		$this->db->order_by('a.seq', 'asc');

		$this->db->where('(a.is_published is not null and a.is_published = 1)');			

		if ($this->is_on_preview()) {

			if ($id = $this->input->get('id')) {

				$this->db->or_where('id', $id);
			}
			else {

				$this->db->or_where('a.is_published', 0);
			}
		}

		$this->db->join('artists b', 'a.artist_id = b.id', 'left');
		
		if ($q = $this->db->get('news a')) {

			foreach($q->result_object() as $r) {

				$this->data['records'][] = $r; 
			}

			$q->free_result();
		}

		$this->view('news');
	}
}