<?php 

class Featured extends MY_Controller {
	
	protected $default_url = '/featured/list';
	protected $tbl = 'featured';
	

	function index() {

		redirect($this->default_url);exit;
	}

	function list_($filter_code = FALSE) {
		
		$this->data['pagenavs'] = array(
            array('add', 'New Feature'),
            array('sort', 'Set Photo Sequence')
        );
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '30%', 'ecls' => 'single_image', 'formatter' => 'thumb', 'url'=> "/assets/[filename]", 'map' => 'filename'),
			(object)array('cls'=>'gtitle', 'label'=>'Project', 'width'=> '55%', 'map' => 'project_name'),
			(object)array('cls'=>'gactions', 'width'=> '10%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x')
		);
		
		$this->data['category'] = (object)array('name' => 'List');

        $s = "
            select
                a.id,
                a.filename,
                b.name as project_name
            from
                featured a
                    join projects b on (a.project_id = b.id)
            order by
                a.seq asc
        ";

		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}
	
	function add() {

		$options = new stdClass;

		$options->tbl = $this->tbl;
		$options->redirect_url = $this->default_url;

		$options->maps = array(
			array('label' => 'Photo*', 'db'=>'filename', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'filename_track', 'rules'=>'callback__validate_file_required', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'filename'),
            array('label' => 'Associated Project', 'db' => 'project_id', 'type' => 'dropdown', 'query' => 'select id, name from projects order by name')
		);
		
		$this->data['category'] = (object) array('name' => 'New Feature');
		$this->_add($options);
	}

	function delete_($id) {

		$options = new stdClass;
		$options->id = (object) ['val' => $id];
		$options->redirect_url = $this->default_url;
		$options->tbl = $this->tbl;
		$this->_delete($options);
	}
    
    
	function sort() {
		
		$options = new stdClass;

		$options->redirect_url = $this->default_url;
		
        $this->data['force_query'] = "
            select
                a.id,
                a.filename
            from
                featured a
                    join projects b on (a.project_id = b.id)
            order by
                a.seq asc
        ";
                    
		$this->data['pagenavs'] = array();
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Photo', 'width'=> '30%', 'ecls' => 'single_image', 'formatter' => 'thumb', 'url'=> "/assets/[filename]", 'map' => 'filename')
		);
		$this->data['category'] = (object)array('name' => 'Set Photo Sequence');
		$options->sortable_cls = 'thumb-sort';
        
        $options->tbl = 'featured';


		$this->_sort($options);
	}
}