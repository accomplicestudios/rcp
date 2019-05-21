<?php 

class Artists_model extends CI_Model {

    const TBL = 'artists'; 
    const TBL_PHOTOS = 'artist_photos';

    function get_all($preview_mode = FALSE) {

			$ret = []; 

			$this->db->where('is_published', 1); 

			if ($preview_mode) {

				$this->db->or_where('id', intval($this->input->get('id')));
			}

			$this->db->order_by('last_name', 'asc');
			$this->db->order_by('first_name', 'asc');

			if ($q = $this->db->get(static::TBL)) {

				foreach($q->result_object() as $r) {

					$ret[] = $this->_morph($r); 
				}

				$q->free_result();
			}

		return $ret; 
  }

	function get_by_slug($slug, $preview_mode = FALSE) {

		// reusing this from old structure
		// we don't anticipate having 10k artists here 
		$ret = NULL; 
		$previous = NULL; 
		$next = NULL; 

		$records = $this->get_all($preview_mode); 

		$roster_count = count($records);

		foreach($records as $k => $record) {

			if ($record->slug === $slug) {

				$ret = $record;

				if ($k > 0) {

					$previous = $records[$k-1];
				} 
				else {
					$previous = $records[$roster_count - 1]; 
				} 

				if ($k == ($roster_count - 1)) {

					$next = $records[0]; 
				}
				else {

					$next = $records[$k+1];
				}

				$ret->previous = $previous; 
				$ret->next = $next; 

				break;
			}
		}

		return $ret;
	}

	protected function _morph($r) {

		$record = $r; 
		$record->list_image = [
			'default' => $r->list_image_desktop, 
			'768' => $r->list_image_tablet
		]; 

		return $record; 
	}
}