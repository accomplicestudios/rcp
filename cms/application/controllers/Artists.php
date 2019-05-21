<?php 

class Artists extends MY_Controller {
	
	protected $default_url = '/artists/list';
	protected $tbl = 'artists';

	function test13123asdfasfdasfasd() {

		$tbls = ['artists', 'exhibitions', 'artist_photos', 'exhibition_photos', 'exhibition_installation_photos'];

		foreach($tbls as $tbl) {

			$q = $this->db->get($tbl);
		
			foreach($q->result_object() as $r) {
				
				$record = []; 
				
				!file_exists('./final-assets') && mkdir('./final-assets');

				isset($r->filename) && copy("./assets/{$r->filename}", "./final-assets/{$r->filename}");
				isset($r->list_image) && copy("./assets/{$r->list_image}", "./final-assets/{$r->list_image}");
				isset($r->list_image_desktop) && copy("./assets/{$r->list_image_desktop}", "./final-assets/{$r->list_image_desktop}");
				isset($r->list_image_tablet) && copy("./assets/{$r->list_image_tablet}", "./final-assets/{$r->list_image_tablet}");

				if (isset($r->press)) {

					$final_name = ''; 

					if ($tbl == 'exhibitions') {

						$final_name = url_title($r->title, '_'); 
					}
					else {

						$final_name = url_title($r->first_name . '_' . $r->last_name, '_'); 
					}

					copy("./assets/{$r->press}", "./final-assets/{$final_name}_Press.pdf");
					$this->db->update($tbl, ['press' => "{$final_name}_Press.pdf"], ['id' => $r->id]);
				} 

				if (isset($r->cv)) {

					$final_name = ''; 

					if ($tbl == 'exhibitions') {

						$final_name = url_title($r->title, '_'); 
					}
					else {

						$final_name = url_title($r->first_name . '_' . $r->last_name, '_'); 
					}

					copy("./assets/{$r->cv}", "./final-assets/{$final_name}_CV.pdf");
					$this->db->update($tbl, ['cv' => "{$final_name}_CV.pdf"], ['id' => $r->id]);
				} 
			}
		}

	}

	function index() {

		redirect($this->default_url);exit;
	}

	function list_($filter_code = FALSE) {
		
		$this->data['pagenavs'] = array(
            array('/artists/add', 'New Artist') 
		);

		// $this->data['pagenavs_right'] = array(
		// 	array(config_item('MAIN_SITE_URL') . 'artists', 'View Live'),         
		// 	array(config_item('MAIN_SITE_URL') . 'artists/?preview=1', 'Preview Live')         
		// );

		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Name', 'width'=> '30%', 'url'=> "{$this->default_url}/edit/[id]", 'map' => 'artist_name'),
			(object)array('cls'=>'gtitle', 'label'=>'CV', 'width'=> '15%', 'map' => 'cv', 'formatter' => 'cv'),
			(object)array('cls'=>'gtitle', 'label'=>'Press', 'width'=> '15%', 'map' => 'press', 'formatter' => 'press'),
            (object)array('cls'=>'gtitle', 'label'=>'Published', 'width'=> '15%', 'map' => 'is_published', 'formatter' => 'booleanify'),
			(object)array('cls'=>'gactions ', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'artist_name'), 
            (object)array('cls'=>'gactions', 'map' => 'is_published', 'width'=> '8%',  'x_url'=> "artist", 'formatter' => 'viewer')
		);
		
		$this->data['category'] = (object)array('name' => 'View All');

		$where_sql = ''; 

		if ($filter_code === 'drafts') {

			$where_sql = 'where (a.is_published is null or a.is_published != 1)'; 
			$this->data['category'] = (object)array('name' => 'Drafts');
		}
		else if ($filter_code === 'published') {

			$where_sql = 'where (a.is_published = 1)'; 
			$this->data['category'] = (object)array('name' => 'Published');
		}

        $s = "
            select 
                a.id, 
                concat(a.last_name, ', ', a.first_name) as artist_name, 
                a.cv, 
                a.press, 
				a.is_published, 
				a.slug
            from 
				{$this->tbl} a
			{$where_sql}
            order by 
                artist_name
        ";

		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}
	
	function add() {

		$options = new stdClass;

		$options->tbl = $this->tbl;
		$options->redirect_url = $this->default_url . '/photos/[id]';
		$options->cancel_url = $this->default_url; 

		$options->maps = array(
            array('label' => 'Last name', 'db' => 'last_name'),
            array('label' => 'First name', 'db'=>'first_name'),
			array('label' => 'CV', 'db'=>'cv', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'cv_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'cv'), 
			array('label' => 'Press', 'db'=>'press', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'press_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'press'),
			array('label' => 'List Image (Default)*', 'db'=>'list_image_desktop', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'list_image_desktop_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'list_image_desktop'),
			array('label' => 'List Image (Tablet)', 'db'=>'list_image_tablet', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'list_image_tablet_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'list_image_tablet'),
            array('label' => 'Publish', 'db'=>'is_published', 'type' => 'check', 'rules' => 'trim')
        );
		
        $this->data['category'] = (object) array('name' => 'New Artist');
		$this->_add($options);
	}
	
	function _post_add($id, $tbl) {

		if ($tbl === 'artists') {

			$q = $this->db->get_where($tbl, ['id' => $id]); 

			if ($q->num_rows()) {

				$permalinks = ''; 

				if ($record = $q->row()) {
				
					$permalinks = url_title(mb_strtolower($record->first_name . ' ' . $record->last_name));
				}

				$q = $this->db->get_where($tbl, ['slug' => $permalinks]);

				if ($q->num_rows()) {

					$permalinks .= "-" . $id;
				}

				$this->db->where('id', $id);
				$this->db->set('slug', $permalinks);
				$this->db->update($tbl);

				$q->free_result();
			}			
		}
		else if ($tbl === 'artist_photos') {

			$q = $this->db->get_where($tbl, ['id' => $id]); 

			if ($q->num_rows()) {
	
				if ($record = $q->row()) {

					$s = "select coalesce(max(position), 1) as position from artist_photos where artist_id = {$record->artist_id}";

					if ($q = $this->db->query($s)) {

						if ($r = $q->row()) {

							$this->db->set('position', $r->position + 1);
							$this->db->where('id', $record->id);
							$this->db->update('artist_photos');
						}
					}
				}
			}
		}

		return TRUE; 
	}
    
    function edit_($id) {
		$options = new stdClass;

		$options->tbl = $this->tbl;
		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0; 

		$this->data['tabs'] = array(
			'details' => array('name'=>'Details', 'add' =>'asdf',  'edit'=>'/artists/list/edit/[id]', 'active'=>TRUE),
			'photos' => array('name'=>'Photos', 'add' =>'adsf', 'edit'=>'/artists/list/photos/[id]', 'active' =>FALSE)
		);		

		$options->maps = array(
            array('label' => 'Last name', 'db' => 'last_name'),
            array('label' => 'First name', 'db'=>'first_name'),
			array('label' => 'CV', 'db'=>'cv', 'rules'=>'trim', 'type'=>'file', 'deletable' => TRUE),
			array('label' => '', 'db'=>'cv_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'cv'), 
			array('label' => 'Press', 'db'=>'press', 'rules'=>'trim', 'type'=>'file',  'deletable' => TRUE),
			array('label' => '', 'db'=>'press_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'press'),
			array('label' => 'List Image (Default)*', 'db'=>'list_image_desktop', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'list_image_desktop_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'list_image_desktop'),
			array('label' => 'List Image (Tablet)', 'db'=>'list_image_tablet', 'rules'=>'trim', 'type'=>'file',  'deletable' => TRUE),
			array('label' => '', 'db'=>'list_image_tablet_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'list_image_tablet'),
			array('label' => 'Permalinks', 'db'=>'slug', 'rules' => 'trim|required|mb_strtolower|url_title'),
			array('label' => 'Publish', 'db'=>'is_published', 'type' => 'check', 'rules' => 'trim')
        );

        $options->id = (object) ['val' => $id];
		$this->data['category'] = (object) array('name' => 'Edit > ' . $this->_name('artists', $id, "last_name") . ', ' . $this->_name('artists', $id, "first_name"));
		$this->data['id'] = $id; 

        $is_published = $this->_name('artists', $id, "is_published");

        if ($is_published) {

            $this->data['factions'] = array(array(config_item('MAIN_SITE_URL') . 'artists/profile/' . $this->_name("artists", $id, 'slug'), 'View Live', "_blank"));			
        }
        else {

            $this->data['factions'] = array(array(config_item('MAIN_SITE_URL') . 'artists/profile/' . $this->_name("artists", $id, 'slug') . '?preview=1&id=' . $id, 'Preview Live', "_blank"));			
        }

		$this->_edit($options);
    }


	function delete_($id) {

		$options = new stdClass;
		$options->id = (object)['val' => $id];
		$options->redirect_url = $this->default_url;
		$options->tbl = $this->tbl;
		$this->_delete($options);
	}

	function sort() {
		
		$options = new stdClass;

		$options->tbl = $this->tbl ;
		$options->order_by = 'seq'; 
		$options->redirect_url = $this->default_url;
		
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Title', 'width'=> '40%', 'map' => 'title'),

		);

		$this->data['category'] = (object)array('name' => 'Set Order');
		$this->_sort($options);
	}


	function photos($id) {
		
		ini_set('error_reporting', E_ALL);
		
		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0;
		$options->tbl = 'artist_photos';

		$this->data['tabs'] = array(
			'details' => array('name'=>'Details', 'add' =>'asdf',  'edit'=>'/artists/list/edit/[id]', 'active'=>FALSE),
			'photos' => array('name'=>'Photos', 'add' =>'adsf', 'edit'=>'/artists/list/photos/[id]', 'active' =>TRUE)
		);
		
		$this->data['category'] = (object) array('name' => 'Manage Photos > ' . $this->_name($this->tbl, $id, 'last_name') . ', ' . $this->_name($this->tbl, $id, 'first_name'));
		$this->data['id'] = $id;
		$this->data['action_type'] = 'edit';

		$this->data['listQ'] = $this->get_photos_by_artist($id);
		$this->default_url .= "/photos/{$id}";		

		$this->data['tabnavs'] = array(
			array("{$id}/add", 'Add Photo'),						   
			array("{$id}/sort",'Set Photo Sequence')
		);

		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '15%', 'ecls' => 'file_actions single_image', 'formatter' => 'thumb', 'url'=> "{$this->default_url}/edit/[id]", 'map' => 'filename'),
			(object)array('cls'=>'gtitle', 'label'=>'Description', 'width'=> '70%', 'map' => 'description'),

			(object)array('cls'=>'gactions', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'description')
		);
		
		$this->_list();
	}
	
	function photo_delete($artist_id, $id) {

		$this->db->where('artist_id', $artist_id);
		$this->db->where('id', $id);
		$this->db->delete('artist_photos');

		redirect('/artists/list/photos/' . $artist_id);		
	}
	
	
	function photo_add($artist_id) {
		
		$options = new stdClass;

		$options->tbl = 'artist_photos';
		$options->redirect_url = "{$this->default_url}/photos/{$artist_id}";

		$options->maps = array(

			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
			array('label' => 'Description', 'db'=>'description'),
			array('label' => '', 'type' => 'hidden', 'db' => 'artist_id', 'def' => $artist_id), 
			array('label' => '', 'type' => 'hidden', 'db' => 'position', 'def' => 0)
		);
		
			
		$this->data['category'] = (object)array('name' => 'Manage Photos > ' 
			. ucwords($this->_name($this->tbl, $artist_id, 'last_name')) . ', ' 
			. ucwords($this->_name($this->tbl, $artist_id, 'first_name')) 
			. ' > Add Photo');
				
		$this->_add($options);
	}

	function photo_edit($artist_id, $id) {
		
		$options = new stdClass;

		$options->tbl = 'artist_photos';
		$options->redirect_url = "{$this->default_url}/photos/{$artist_id}";

		$options->maps = array(

			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
			array('label' => 'Description', 'db'=>'description'),
			array('label' => '', 'type' => 'hidden', 'db' => 'artist_id', 'def' => $artist_id)
		);
		
			
		$this->data['category'] = (object)array('name' => 'Manage Photos > ' 
			. ucwords($this->_name($this->tbl, $artist_id, 'last_name')) . ', ' 
			. ucwords($this->_name($this->tbl, $artist_id, 'first_name')) 
			. ' > Edit Photo');

		$options->id = (object)['val' => $id]; 		

		$this->_edit($options);
	}	
	
	function photo_sort($artist_id) {

		$options = new stdClass;
			
		$this->data['category'] = (object)array('name' => 'Manage Photos > ' 
			. ucwords($this->_name($this->tbl, $artist_id, 'last_name')) . ', ' 
			. ucwords($this->_name($this->tbl, $artist_id, 'first_name')) 
			. ' > Set Sequence');

		$options->tbl = 'artist_photos';
		$options->where = array('artist_id' => $artist_id);

		$options->order_by = 'position'; 
		$options->redirect_url = "/artists/list/photos/{$artist_id}";
		
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '30%', 'ecls' => 'single_image', 'formatter' => 'thumb', 'url'=> "/assets/[filename]", 'map' => 'filename')
		);

		$options->sortable_cls = 'thumb-sort';
		
		$this->_sort($options, 'position');
	}
		
	
	protected function get_photos_by_artist($artist_id) {
		
		$this->db->where('artist_id', $artist_id);
		$this->db->order_by('position', 'asc');
		return $this->db->get('artist_photos');
	}
}