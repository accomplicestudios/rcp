<?php 

class Exhibitions extends MY_Controller {
	
	protected $default_url = '/exhibitions/list';
	protected $tbl = 'exhibitions';

	function index() {

		redirect($this->default_url);exit;
	}

	function list_($filter_code = NULL) {
		
		$this->data['pagenavs'] = array(
            array('/exhibitions/add', 'New Exhibition')
        );
				
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Title', 'width'=> '25%', 'url'=> "{$this->default_url}/edit/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label'=>'Artist', 'width'=> '25%', 'map' => 'artist_name'),
			(object)array('cls'=>'gtitle', 'label'=>'Press', 'width'=> '10%', 'map' => 'press', 'formatter' => 'press'),
			(object)array('cls'=>'gtitle', 'label'=>'Start Date', 'width'=> '12%', 'map' => 'date_start'),
			(object)array('cls'=>'gtitle', 'label'=>'Published', 'width'=> '12%', 'map' => 'is_published', 'formatter' => 'booleanify'),
			(object)array('cls'=>'gactions ', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'title'), 
            (object)array('cls'=>'gactions', 'map' => 'is_published', 'width'=> '8%',  'x_url'=> "exhibition", 'formatter' => 'viewer')
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
		else if ($filter_code === 'current') {

			$where_sql = "where (a.date_start <= curdate() and a.date_end >= curdate())";
			$this->data['category'] = (object)array('name' => 'Current');
		}
		else if ($filter_code === 'upcoming') {

			$where_sql = "where (a.date_start > curdate())";
			$this->data['category'] = (object)array('name' => 'Upcoming');
		}
		else if ($filter_code === 'past') {

			$where_sql = "where (a.date_end < curdate())";
			$this->data['category'] = (object)array('name' => 'Past');
		}
		
		$s = "
            select 
                a.id, 
                a.title, 
				a.date_start, 
				a.is_published,
				a.press, 
				concat(b.last_name, ', ', b.first_name) as artist_name, 
				a.slug
            from 
                {$this->tbl} a 
					left join artists b on (a.artist_id = b.id)
			{$where_sql}
            order by 
                a.date_start desc 
        ";

		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}
	
	function add() {

		$options = new stdClass;

		$options->tbl = $this->tbl ;
		$options->redirect_url = $this->default_url . "/photos/[id]";
		$options->cancel_url = $this->default_url; 

		$options->maps = array(

			array('label' => 'Artist', 'db' => 'artist_id', 'type' => 'dropdown', 'query' => "select '' as id, '' as name from dual union select id, concat(last_name, ', ', first_name) as name from artists order by name"), 
			array('label' => 'Title', 'db'=>'title'),
			array('label' => 'Start Date', 'db'=>'date_start', 'type' => 'date', 'rules' => 'trim|callback__validate_date_required[date_start]', 'allow_empty' => TRUE),
			array('label' => 'End Date', 'db'=>'date_end', 'type' => 'date', 'rules' => 'trim|callback__validate_date_required[date_end]', 'allow_empty' => TRUE),
			array('label' => 'Description', 'db'=>'subtitle', 'rules' => 'trim'),
			array('label' => 'Press', 'db'=>'press', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'press_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'press'),
			array('label' => 'List Image*', 'db'=>'list_image', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'list_image_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'list_image'),
			array('label' => 'Publish', 'db'=>'is_published', 'type' => 'check', 'rules' => 'trim')

		);
		
		$this->data['category'] = (object) array('name' => 'New Exhibition');
		$this->_add($options);		
	}
	
	function edit_($id) {

		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0;
		$options->tbl = $this->tbl;

		$this->data['tabs'] = array(
			'details' => array('name'=>'Details', 'add' =>'asdf',  'edit'=>'/exhibitions/list/edit/[id]', 'active'=>TRUE),
			'photos' => array('name'=>'Photos', 'add' =>'adsf', 'edit'=>'/exhibitions/list/photos/[id]', 'active' =>FALSE), 
			'installation' => array('name'=>'Installation', 'add' =>'adsf', 'edit'=>'/exhibitions/list/installation/[id]', 'active' =>FALSE)
		);
		
		$options->maps = array(
			array('label' => 'Artist', 'db' => 'artist_id', 'type' => 'dropdown', 'query' => "select '' as id, '' as name from dual union select id, concat(last_name, ', ', first_name) as name from artists order by name"), 
			array('label' => 'Title', 'db'=>'title'),
			array('label' => 'Start Date', 'db'=>'date_start', 'type' => 'date', 'rules' => 'trim|callback__validate_date_required[date_start]', 'allow_empty' => TRUE),
			array('label' => 'End Date', 'db'=>'date_end', 'type' => 'date', 'rules' => 'trim|callback__validate_date_required[date_end]', 'allow_empty' => TRUE),
			array('label' => 'Description', 'db'=>'subtitle', 'rules' => 'trim'),
			array('label' => 'Press', 'db'=>'press', 'rules'=>'trim', 'type'=>'file', 'deletable' => TRUE),
			array('label' => '', 'db'=>'press_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'press'),
			array('label' => 'List Image*', 'db'=>'list_image', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'list_image_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'list_image'),
			array('label' => 'Permalinks', 'db'=>'slug', 'rules' => 'trim|required|mb_strtolower|url_title'),
			array('label' => 'Publish', 'db'=>'is_published', 'type' => 'check', 'rules' => 'trim')
		);

		$options->id = (object) ['val' => $id];
		$this->data['category'] = (object) array('name' => 'Edit > ' . $this->_name($this->tbl, $id, 'title'));
		$this->data['id'] = $id;


        $is_published = $this->_name($this->tbl, $id, "is_published");

        if ($is_published) {

            $this->data['factions'] = array(array(config_item('MAIN_SITE_URL') . 'exhibitions/profile/' . $this->_name($this->tbl, $id, 'slug'), 'View Live', "_blank"));			
        }
        else {

            $this->data['factions'] = array(array(config_item('MAIN_SITE_URL') . 'exhibitions/profile/' . $this->_name($this->tbl, $id, 'slug') . '?preview=1&id=' . $id, 'Preview Live', "_blank"));			
		}
				

		$this->_edit($options);
	}

	function delete_($id) {

		$options = new stdClass;
		$options->id = (object) ['val' => $id];
		$options->redirect_url = $this->default_url;
		$options->tbl = $this->tbl;
		$this->_delete($options);
	}
	
	function photos($id) {
		
		ini_set('error_reporting', E_ALL);
		
		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0;
		$options->tbl = 'exhibition_photos';

		$this->data['tabs'] = array(
			'details' => array('name'=>'Details', 'add' =>'asdf',  'edit'=>'/exhibitions/list/edit/[id]', 'active'=>FALSE),
			'photos' => array('name'=>'Photos', 'add' =>'adsf', 'edit'=>'/exhibitions/list/photos/[id]', 'active' =>TRUE), 
			'installation' => array('name'=>'Installation', 'add' =>'adsf', 'edit'=>'/exhibitions/list/installation/[id]', 'active' =>FALSE)
		);
		
		$this->data['category'] = (object) array('name' => 'Manage Photos > ' . $this->_name($this->tbl, $id, 'title'));
		$this->data['id'] = $id;
		$this->data['action_type'] = 'edit';

		$this->data['listQ'] = $this->get_photos_by_exhibition($id);
		$this->default_url .= "/photos/{$id}";		

		$this->data['tabnavs'] = array(
			array("{$id}/add", 'Add Photo'),						   
			array("{$id}/sort",'Set Photo Sequence')
		);

		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '10%', 'ecls' => 'file_actions single_image', 'formatter' => 'thumb', 'url'=> "{$this->default_url}/edit/[id]", 'map' => 'filename'),
			(object)array('cls'=>'gtitle', 'label'=>'Description', 'width'=> '80%', 'map' => 'description'),

			(object)array('cls'=>'gactions', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'description') 
		);
		
		$this->_list();
	}
	
	function photo_delete($exhibition_id, $id) {

		$this->db->where('exhibition_id', $exhibition_id);
		$this->db->where('id', $id);
		$this->db->delete('exhibition_photos');

		redirect('/exhibitions/list/photos/' . $exhibition_id);		
	}
	
	function photo_add($exhibition_id) {
		
		$options = new stdClass;

		$options->tbl = 'exhibition_photos';
		$options->redirect_url = "{$this->default_url}/photos/{$exhibition_id}";

		$options->maps = array(

			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
			array('label' => 'Description', 'db'=>'description'),
			array('label' => '', 'type' => 'hidden', 'db' => 'exhibition_id', 'def' => $exhibition_id), 
			array('label' => '', 'type' => 'hidden', 'db' => 'position', 'def' => 0), 
		);
			
		$this->data['category'] = (object)array('name' => 'Manage Photos > ' . ucwords($this->_name($this->tbl, $exhibition_id, 'title')) .  ' > Add Photo');
		$this->_add($options);
	}

	function photo_edit($exhibition_id, $id) {
		
		$options = new stdClass;

		$options->tbl = 'exhibition_photos';
		$options->redirect_url = "{$this->default_url}/photos/{$exhibition_id}";

		$options->maps = array(

			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
			array('label' => 'Description', 'db'=>'description'),
			array('label' => '', 'type' => 'hidden', 'db' => 'exhibition_id', 'def' => $exhibition_id)
		);
		
			
		$this->data['category'] = (object)array('name' => 'Manage Photos > ' . ucwords($this->_name($this->tbl, $exhibition_id, 'title')) .  ' > Edit Photo');
		$options->id = (object)['val' => $id]; 		
		$this->_edit($options);
	}	
	
	function photo_sort($exhibition_id) {

		$options = new stdClass;
			
		$this->data['category'] = (object)array('name' => 'Manage Photos > ' . ucwords($this->_name($this->tbl, $exhibition_id, 'title')) .  ' > Set Photo Sequence');

		$options->tbl = 'exhibition_photos';
		$options->where = array('exhibition_id' => $exhibition_id);

		$options->order_by = 'position'; 
		$options->redirect_url = "/exhibitions/list/photos/{$exhibition_id}";
		
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '30%', 'ecls' => 'single_image', 'formatter' => 'thumb', 'url'=> "/assets/[filename]", 'map' => 'filename')
		);

		$options->sortable_cls = 'thumb-sort';
		
		$this->_sort($options, 'position');
	}
	
	protected function get_photos_by_exhibition($exhibition_id) {
		
		$this->db->where('exhibition_id', $exhibition_id);
		$this->db->order_by('position', 'asc');
		return $this->db->get('exhibition_photos');
	}

	/////////////////////////////////////////////////////////////////////////


	function installation($id) {
		
		ini_set('error_reporting', E_ALL);
		
		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		$options->force_redirect = 0;
		$options->tbl = 'exhibition_installation_photos';

		$this->data['tabs'] = array(
			'details' => array('name'=>'Details', 'add' =>'asdf',  'edit'=>'/exhibitions/list/edit/[id]', 'active'=>FALSE),
			'photos' => array('name'=>'Photos', 'add' =>'adsf', 'edit'=>'/exhibitions/list/photos/[id]', 'active' =>FALSE), 
			'installation' => array('name'=>'Installation', 'add' =>'adsf', 'edit'=>'/exhibitions/list/installation/[id]', 'active' =>TRUE)
		);
		
		$this->data['category'] = (object) array('name' => 'Manage Installation Views > ' . $this->_name($this->tbl, $id, 'title'));
		$this->data['id'] = $id;
		$this->data['action_type'] = 'edit';

		$this->data['listQ'] = $this->get_installation_photos_by_exhibition($id);
		$this->default_url .= "/installation/{$id}";		

		$this->data['tabnavs'] = array(
			array("{$id}/add", 'Add Photo'),						   
			array("{$id}/sort",'Set Photo Sequence')
		);

		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '10%', 'ecls' => 'file_actions single_image', 'formatter' => 'thumb', 'url'=> "{$this->default_url}/edit/[id]", 'map' => 'filename'),
			(object)array('cls'=>'gtitle', 'label'=>'Description', 'width'=> '80%', 'map' => 'description'),

			(object)array('cls'=>'gactions', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'description') 
		);
		
		$this->_list();
	}
	
	function installation_delete($exhibition_id, $id) {

		$this->db->where('exhibition_id', $exhibition_id);
		$this->db->where('id', $id);
		$this->db->delete('exhibition_installation_photos');

		redirect('/exhibitions/list/installation/' . $exhibition_id);		
	}
	
	function installation_add($exhibition_id) {
		
		$options = new stdClass;

		$options->tbl = 'exhibition_installation_photos';
		$options->redirect_url = "{$this->default_url}/installation/{$exhibition_id}";

		$options->maps = array(

			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
			array('label' => 'Description', 'db'=>'description'),
			array('label' => '', 'type' => 'hidden', 'db' => 'exhibition_id', 'def' => $exhibition_id), 
			array('label' => '', 'type' => 'hidden', 'db' => 'position', 'def' => 0), 
		);
			
		$this->data['category'] = (object)array('name' => 'Manage Installation Views > ' . ucwords($this->_name($this->tbl, $exhibition_id, 'title')) .  ' > Add Photo');
		$this->_add($options);
	}

	function installation_edit($exhibition_id, $id) {
		
		$options = new stdClass;

		$options->tbl = 'exhibition_installation_photos';
		$options->redirect_url = "{$this->default_url}/installation/{$exhibition_id}";

		$options->maps = array(

			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
			array('label' => 'Description', 'db'=>'description'),
			array('label' => '', 'type' => 'hidden', 'db' => 'exhibition_id', 'def' => $exhibition_id)
		);
		
			
		$this->data['category'] = (object)array('name' => 'Manage Installation Views > ' . ucwords($this->_name($this->tbl, $exhibition_id, 'title')) .  ' > Edit Photo');
		$options->id = (object)['val' => $id]; 		
		$this->_edit($options);
	}	
	
	function installation_sort($exhibition_id) {

		$options = new stdClass;
			
		$this->data['category'] = (object)array('name' => 'Manage Installation Views > ' . ucwords($this->_name($this->tbl, $exhibition_id, 'title')) .  ' > Set Photo Sequence');

		$options->tbl = 'exhibition_installation_photos';
		$options->where = array('exhibition_id' => $exhibition_id);

		$options->order_by = 'position'; 
		$options->redirect_url = "/exhibitions/list/installation/{$exhibition_id}";
		
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '30%', 'ecls' => 'single_image', 'formatter' => 'thumb', 'url'=> "/assets/[filename]", 'map' => 'filename')
		);

		$options->sortable_cls = 'thumb-sort';
		
		$this->_sort($options, 'position');
	}
	
	protected function get_installation_photos_by_exhibition($exhibition_id) {
		
		$this->db->where('exhibition_id', $exhibition_id);
		$this->db->order_by('position', 'asc');
		return $this->db->get('exhibition_installation_photos');
	}


	protected function _post_add($id, $tbl) {

		if (in_array($tbl, ['exhibition_photos', 'exhibition_installation_photos'])) {

			$q = $this->db->get_where($tbl, ['id' => $id]); 

			if ($q->num_rows()) {
	
				if ($record = $q->row()) {

					$s = "select coalesce(max(position), 1) as position from {$tbl} where exhibition_id = {$record->exhibition_id}";

					if ($q = $this->db->query($s)) {

						if ($r = $q->row()) {

							$this->db->set('position', $r->position + 1);
							$this->db->where('id', $record->id);
							$this->db->update($tbl);
						}
					}
				}
			}
		}
		else {

			$q = $this->db->get_where($tbl, ['id' => $id]); 

			if ($q->num_rows()) {

				$permalinks = []; 

				if ($record = $q->row()) {
				
					array_unshift($permalinks, url_title(mb_strtolower($record->title)));
										
					if ($qa = $this->db->get_where('artists', ['id' => $record->artist_id])) {

						if ($r = $qa->row()) {

							array_unshift($permalinks, url_title(mb_strtolower($r->first_name . ' ' . $r->last_name)));
						}

						$qa->free_result();
					}

					$permalinks = implode('-', $permalinks);
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

        return TRUE; 
    }
	
}