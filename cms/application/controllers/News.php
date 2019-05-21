<?php 

class News extends MY_Controller {
	
	protected $default_url = '/news/list';
	protected $tbl = 'news';
	

	function index() {

		redirect($this->default_url);exit;
	}

	function list_($filter_code = FALSE) {
		
		$this->data['pagenavs'] = array(
            array('/news/add', 'New Item'),
            array('/news/sort', 'Set Order')
        );

		$this->data['pagenavs_right'] = array(
			array(config_item('MAIN_SITE_URL') . 'news', 'View Live', '_blank'),         
			array(config_item('MAIN_SITE_URL') . 'news/?preview=1', 'Preview Live', '_blank')         
		);		

		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'Title', 'width'=> '50%', 'url'=> "/news/edit/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label'=>'Artist', 'width'=> '30%', 'map' => 'artist_name'),
			(object)array('cls'=>'gtitle', 'label'=>'Published', 'width'=> '10%', 'map' => 'is_published', 'formatter' => 'booleanify'),
            (object)array('cls'=>'gactions ', 'width'=> '4%',  'url'=> "{$this->default_url}/delete/[id]", 'title' => 'x', 'record_map' => 'title')
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
                a.title, 
                a.is_published, 
                concat(b.last_name, ', ', b.first_name) as artist_name
            from 
                {$this->tbl} a 
                    left join artists b on (a.artist_id = b.id)
            {$where_sql}
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
            array('label' => 'Artist', 'db' => 'artist_id', 'rules' => 'trim', 'type' => 'dropdown', 'query' => "select '' as id, '' as name from dual union select id, concat(last_name, ', ', first_name) as name from artists order by name"), 
            array('label' => 'Title', 'db'=>'title'),
			array('label' => 'Subtitle / Dates', 'db'=>'subtitle', 'rules' => 'trim'),
			array('label' => 'Link Name', 'db'=>'link_name'),
			array('label' => 'Link', 'db'=>'link_url'),
            array('label' => 'Publish', 'db'=>'is_published', 'type' => 'check', 'rules' => 'trim')
        );
		
		$this->data['category'] = (object) array('name' => 'New Item');
		$this->_add($options);
    }
    
    function edit($id) {
        $options = new stdClass;

        $options->redirect_url = $this->default_url;
        $options->force_redirect = 0;
        $options->tbl = $this->tbl;
    
        $options->maps = array(
            array('label' => 'Artist', 'db' => 'artist_id', 'rules' => 'trim', 'type' => 'dropdown', 'query' => "select '' as id, '' as name from dual union select id, concat(last_name, ', ', first_name) as name from artists order by name"), 
            array('label' => 'Title', 'db'=>'title'),
			array('label' => 'Subtitle / Dates', 'db'=>'subtitle', 'rules' => 'trim'),
			array('label' => 'Link Name', 'db'=>'link_name'),
			array('label' => 'Link', 'db'=>'link_url'),
            array('label' => 'Publish', 'db'=>'is_published', 'type' => 'check', 'rules' => 'trim')
        );
    
        
        $options->id = (object) ['val' => $id];
        $this->data['category'] = (object) array('name' => 'Edit > ' . $this->_name('news', $id, 'title'));
                
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
            (object)array('cls'=>'gtitle', 'label'=>'Title', 'width'=> '100%', 'map' => 'title', 'formatter' => 'news_sort_item')
		);

        $this->data['category'] = (object)array('name' => 'Set Order');
        $this->data['force_query'] = "
            select 
                a.id, 
                a.title, 
                a.subtitle, 
                concat(b.last_name, ', ', b.first_name) as artist_name
            from 
                {$this->tbl} a 
                    left join artists b on (a.artist_id = b.id)
            order by 
                a.seq asc 
        ";


		$this->_sort($options);
	}

	protected function _post_add($id, $tbl) {
	
		$this->db->set('seq', 'seq + 1', FALSE); 
		$this->db->where('id !=', $id); 
		$this->db->update($this->tbl);
	}
}