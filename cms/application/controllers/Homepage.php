<?php 

class Homepage extends MY_Controller {
	
	protected $default_url = '/homepage/list';
	protected $tbl = 'homepages';
    const LAYOUT_CHOICES = [
        'full' => 'Full', 
        'boxed' => 'Boxed', 
        'split-left' => 'Split (Left Image)', 
        'split-right' => 'Split (Right Image)'
    ];
    const LOGO_TYPES = [
        'black' => 'Black', 
        'white' => 'White'
    ]; 
    const MENU_COLORS = [
        'black' => 'Black', 
        'white' => 'White'
    ];

	function index() {

		redirect($this->default_url);exit;
	}

	function list_($filter_code = FALSE) {
		
		$this->data['pagenavs'] = array(
            array('add', 'New Design')        
        );

        $this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'title', 'width'=> '30%', 'url'=> "/homepage/edit/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label'=>'Subtitle', 'width'=> '30%', 'map' => 'subtitle'),
			(object)array('cls'=>'gtitle', 'label'=>'Layout', 'width'=> '10%', 'map' => 'layout', 'formatter' => 'layout'),

            (object)array('cls'=>'gactions ', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'title'), 
            (object)array('cls'=>'gactions', 'map' => 'is_primary', 'width'=> '8%',  'x_url'=> "homepage", 'formatter' => 'viewer'),
            (object)array('cls'=>'gactions', 'map' => 'is_primary', 'width'=> '10%',  'x_url'=> "/homepage/activate/[id]", 'formatter' => 'activate')
		);
		
		$this->data['listQ'] = $this->db->get($this->tbl);
		
		$this->_list();
	}
	
	function add() {

		$options = new stdClass;

		$options->tbl = $this->tbl;
		$options->redirect_url = $this->default_url;

		$options->maps = array(
            array('label' => 'Title', 'db' => 'title'),
            array('label' => 'Subtitle', 'db'=>'subtitle', 'rules' => 'trim'),
			array('label' => 'Line 1', 'db'=>'line1', 'rules' => 'trim'),
			array('label' => 'Line 2', 'db'=>'line2', 'rules' => 'trim'),
			array('label' => 'Link', 'db'=>'link', 'rules' => 'trim'),
            array('label' => 'Layout', 'db'=>'layout', 'type' => 'dropdown', 'values' => static::LAYOUT_CHOICES),
            array('label' => 'Logo Color', 'db' => 'logo_color', 'type' => 'dropdown', 'values' => static::LOGO_TYPES),  
            array('label' => 'Menu Color', 'db' => 'menu_color', 'type' => 'dropdown', 'values' => static::MENU_COLORS),  
            array('label' => 'Image*', 'db'=>'background_image', 'rules'=>'trim', 'type'=>'file'),
            array('label' => '', 'db'=>'background_image_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'background_image'),
			array('label' => 'Image Background Color', 'db'=>'background_color', 'rules' => 'trim'),
            array('label' => 'Active', 'db'=>'is_primary', 'type' => 'check', 'rules' => 'trim')
        );
		
        $this->data['category'] = (object) array('name' => 'New Design');
		$this->_add($options);
    }
    
    function edit($id) {

		$options = new stdClass;

		$options->tbl = $this->tbl;
		$options->redirect_url = $this->default_url;
		$options->maps = array(
            array('label' => 'Title', 'db' => 'title'),
            array('label' => 'Subtitle', 'db'=>'subtitle', 'rules' => 'trim'),
			array('label' => 'Line 1', 'db'=>'line1', 'rules' => 'trim'),
			array('label' => 'Line 2', 'db'=>'line2', 'rules' => 'trim'),
			array('label' => 'Link', 'db'=>'link', 'rules' => 'trim'),
            array('label' => 'Layout', 'db'=>'layout', 'type' => 'dropdown', 'values' => static::LAYOUT_CHOICES),
            array('label' => 'Logo Color', 'db' => 'logo_color', 'type' => 'dropdown', 'values' => static::LOGO_TYPES),  
            array('label' => 'Menu Color', 'db' => 'menu_color', 'type' => 'dropdown', 'values' => static::MENU_COLORS),  
            array('label' => 'Image*', 'db'=>'background_image', 'rules'=>'trim', 'type'=>'file'),
            array('label' => '', 'db'=>'background_image_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
                    'skip_write' => 1, 'def' => 'background_image'),
			array('label' => 'Image Background Color', 'db'=>'background_color', 'rules' => 'trim'),
            array('label' => 'Active', 'db'=>'is_primary', 'type' => 'check', 'rules' => 'trim')
        );
		

        $options->id = (object) ['val' => $id];
        $this->data['category'] = (object) array('name' => 'Edit > ' . $this->_name('homepages', $id, "title"));

        $is_published = $this->_name('homepages', $id, "is_primary");

        if ($is_published) {

            $this->data['factions'] = array(array(config_item('MAIN_SITE_URL'), 'View Live', "_blank"));			
        }
        else {

            $this->data['factions'] = array(array(config_item('MAIN_SITE_URL') . '?preview=true&id=' . $id, 'Preview Live', "_blank"));			
        }

        $this->_edit($options);
    }


	function delete_($id) {

        if ($q = $this->db->get_where($this->tbl, ['id' => $id])) {

            if ($r = $q->row()) {

                if ($r->is_primary == 1) {

                    $this->session->set_flashdata('deleted-error', 'You cannot delete the active design. Create or activate another design first, then proceed with delete.');
                    redirect($this->default_url);
                }
            }

        }

        $options = new stdClass;
        $options->id = (object)['val' => $id];
        $options->redirect_url = $this->default_url;
        $options->tbl = $this->tbl;
        $this->_delete($options);
	}
    
    
	function activate($id) {

		$this->db->update('homepages', array('is_primary' => 0));
		
		$this->db->where(array('id' => $id));
		$this->db->update('homepages', array('is_primary' => 1));
		
		redirect($this->default_url);
    }
    
    function _post_add($id, $tbl) {

        $q = $this->db->get_where($this->tbl, ['id' => $id]); 
        if ($q->num_rows()) {

            if ($record = $q->row()) {

                if ($record->is_primary == 1) {
                    
                    $this->db->where('id !=', $id); 
                    $this->db->update($this->tbl, ['is_primary' => 0]); 
                }
            }
        }

        return TRUE; 
    }

    function _post_update($id, $tbl) {

        return $this->_post_add($id, $tbl);
    }
}