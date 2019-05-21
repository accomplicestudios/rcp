<?php 

die(__FILE__);

class Projects extends MY_Controller {
	
	private $tabs = array();
	protected $default_url = '/projects/categories/list';

	function __construct() {
        die(__FUNCTION__);
    }
	//function __construct() {
	//	
	//	parent::__construct();
	//	
	//	$this->tabs = array(
	//		'details' => array('name'=>'Details', 'add'=>'/projects/list/add/details/[id]', 'edit'=>'/projects/list/edit/details/[id]'),
	//		'formats' => array('name'=>'Formats', 'add'=>'/projects/list/add/formats/list/[id]', 'edit'=>'/projects/list/edit/formats/list/[id]'),
	//		'description' => array('name'=>'Description', 'add'=>'/projects/list/add/description/[id]', 'edit'=>'/projects/list/edit/description/[id]'),
	//		'resources' => array('name'=>'Resources', 'add'=>'/projects/list/add/resources/[id]', 'edit'=>'/projects/list/edit/resources/[id]'),
	//		'reviews' => array('name'=>'Reviews', 'add'=>'/projects/list/add/reviews/list/[id]', 'edit'=>'/projects/list/edit/reviews/list/[id]'),
	//		'images' => array('name'=>'Images', 'add'=>'/projects/list/add/images/[id]', 'edit'=>'/projects/list/edit/images/[id]'),
	//		'purchase' => array('name'=>'Purchase Links', 'add'=>'/projects/list/add/purchase/[id]', 'edit'=>'/projects/list/edit/purchase/[id]')
	//	);
	//}
	function index() {
		
        die(__FUNCTION__);
		redirect('/projects/list');
	}
	
	function list_($genre = 0) {

        die(__FUNCTION__);
        
		$genre_name = "";
		
		if ($genre == 0) {
			
			$this->db->order_by('name', 'asc');
			$q = $this->db->get('genres', 1);
			
			if ($q->num_rows()) {

				$row = $q->row();
				redirect('/projects/list/' . $row->id);exit;
			}
			else {
				
				redirect('/projects/categories/list');exit;
			}
		}
			
		$q = $this->db->get_where('genres', array('id' => $genre));
		
		if ($q->num_rows()) {
			
			$genre_name = $q->row()->name;
		}
		
		$url_prefix = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("/projects/temp", 'Add Book')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label' => 'book title', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/details/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label' => 'Author', 'width'=> '30%', 'map' => 'author')
		);
		
		$s = "
			select
				books.*	
			from
				book_genres,
				books
			where
				book_genres.genre_id = {$genre} and
				book_genres.book_id = books.id
			order by
				books.title asc
		";
		
		$this->data['listQ'] = $this->db->query($s);
		$this->data['category'] = (object) array('name' => $genre_name);
		$this->_list();
	}

	function delete_($id) {

		$options = new stdClass;
		$options->id = (object) ['val' => $id];
		$options->redirect_url = '/projects/list';
		$options->tbl = 'books';

		$this->db->where('book_id', $id);
		$this->db->delete('book_genres');
		
		$this->db->where('book_id', $id);
		$this->db->delete('book_formats');

		$this->_delete($options);
	}
	
			
	
	function temp() {
		
		$record = array('title' => '');
		$this->db->insert('temp_books', $record);
				
		redirect('/projects/list/add/details/' . $this->db->insert_id(), 'refresh');
		exit;
	}
	
	function x(){
		$this->db->query("update categories set name = 'Browse Teaching Guides' where name = 'Browse Teaching Guide'");
	}
	
	function publish($id) {

		$s = "
			insert into
				books
			(
				title,
				author,
				author_bio,
				illustrator,
				illustrator_bio,
				color,
				bisac,
				featured,
				new_release,
				bestseller,
				teaching_guide,
				age_range,
				traits,
				description,
				guided_reading_levels, 
				lexile,
				fountas,
				accelerated,
				reading_counts,
				file1,
				file2,
				file3,
				file4,
				file5,
				description1,
				description2,
				description3,
				description4,
				description5,
				image1,
				image2,
				image3,
				buy_astore,
				buy_barnes,
				buy_borders,
				buy_indiebound,
				buy_iphone,
				cover_thumb,
				cover_medium,
				cover_large
			)
			select
				title,
				author,
				author_bio,
				illustrator,
				illustrator_bio,
				color,
				bisac,
				featured,
				new_release,
				bestseller,
				teaching_guide,
				age_range,
				traits,
				description,
				guided_reading_levels,
				lexile,
				fountas,
				accelerated,
				reading_counts,
				file1,
				file2,
				file3,
				file4,
				file5,
				description1,
				description2,
				description3,
				description4,
				description5,
				image1,
				image2,
				image3,
				buy_astore,
				buy_barnes,
				buy_borders,
				buy_indiebound,
				buy_iphone,
				cover_thumb,
				cover_medium,
				cover_large
			from
				temp_books
			where
				id = {$id}
		";
		
		$this->db->query($s);
		
		$new_id = $this->db->insert_id();
		
		$s = "
			insert into
				book_formats
			(
				book_id,
				format_id,
				bisac, 
				isbn13,
				isbn10,
				price,
				pub_date,
				pages,
				dimensions
			)
			select
				{$new_id} as book_id,
				format_id,
				bisac, 
				isbn13,
				isbn10,
				price,
				pub_date,
				pages,
				dimensions
			from
				temp_book_formats
			where
				book_id = {$id}
		";
		
		$this->db->query($s);
		
		$s = "
			insert into
				book_genres
			(
				book_id,
				genre_id
			)
			select
				{$new_id} as book_id,
				genre_id
			from
				temp_book_genres
			where
				book_id = {$id}
		";
		
		$this->db->query($s);

		$s = "
			insert into
				reviews
			(
				book_id,
				member_id,
				description,
				rating,
				type,
				status,
				date_add
			)
			select
				{$new_id} as book_id,
				member_id,
				description,
				rating,
				type,
				status,
				date_add
			from
				temp_reviews
			where
				book_id = {$id}
		";
		
		$this->db->query($s);

		
		redirect('/projects/all/list', 'refresh');
		exit;
	}
	
	function book_edit_details($type, $id) {

		$options = new stdClass;

		$options->tbl = 'books';
		$options->redirect_url = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("", "Update Details")
		);
		
		$this->data['category'] = (object) array('name' => 'Update Book');
		$this->data['factions'] = array(array("/projects/list/delete/{$id}", 'Delete'));			

		if ($type === 'add') {
			
			$options->tbl = "temp_books";
			$this->data['pagenavs'] = array(
				array("", 'Add Details')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
			$this->data['factions'] = array(array("/projects/publish/{$id}", "Publish")); 
		}

		$options->maps = array(
			array('label' => 'Book Title', 'db'=>'title', 'sep'=>1),

			array('label' => 'Author', 'db'=>'author', 'rules'=>'trim'),
			array('label' => 'Author Bio', 'db'=>'author_bio', 'rules'=>'trim|max_length[400]','type'=>'textarea', 'sep'=>1),

			array('label' => 'Illustrator', 'db'=>'illustrator',  'rules'=>'trim'),
			array('label' => 'Illustrator Bio', 'db'=>'illustrator_bio', 'sep'=>1, 'rules'=>'trim|max_length[400]', 'type'=>'textarea'),
			
			array('label' => 'Color', 'db' => 'color', 'type'=>'radio', 'values'=>array(1=>'Yes', 0=>'No'), 'rules'=>'trim', 'sep'=>1), 

			array('label' => 'Featured', 'db' => 'featured', 'section'=>'Display in', 'type'=>'check', 'rules'=>'trim'),
			array('label' => 'New Releases', 'db' => 'new_release', 'type'=>'check', 'rules'=>'trim'),
			array('label' => 'Bestseller', 'db' => 'bestseller', 'type'=>'check', 'rules'=>'trim'), 
			array('label' => 'Teaching Guides', 'db' => 'teaching_guide', 'type'=>'check', 'rules'=>'trim')
		);

		$options->id = (object) ['val' => $id];['val' => $id];
		$this->tabs['details']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		
		$this->data['submit'] = 'Save Details';
		$this->_edit($options);
	}
	
	function book_formats_list($type, $id) {

		$url_prefix = "/projects/list/edit/formats/list/{$id}";
		$tbl = "book_formats";

		$this->data['pagenavs'] = array(
			array("", "Update Book Formats")
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		
		if ($type === 'add') {

			$url_prefix = "/projects/list/add/formats/list/{$id}";
			$tbl = 'temp_book_formats';
			$this->data['pagenavs'] = array(
				array("", 'Add Book Formats')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
			

		}
		$this->data['tabnavs'] = array(
			array("{$url_prefix}/add", 'Add Format')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/[id]", 'map' => 'name'),
			(object)array('cls'=>'gactions', 'width'=> '15%',  'url'=> "{$url_prefix}/delete/[id]", 'title' => 'delete')
		);
		
		$s = "
			select
				{$tbl}.id,
				formats.name
			from
				{$tbl},
				formats
			where
				book_id = {$id} and
				formats.id = {$tbl}.format_id 
		";

		$this->data['listQ'] = $this->db->query($s);
		$this->tabs['formats']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		
		$this->_list();
	}

	function book_formats_add($type, $id) {

		$options = new stdClass;

		$options->tbl = 'book_formats';
		$options->redirect_url = "/projects/list/edit/formats/list/{$id}";
		$this->data['pagenavs'] = array(
			array("", 'Update Book Formats')
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		
		if ($type === 'add') {
		
			$options->tbl = 'temp_book_formats';	
			$options->redirect_url = "/projects/list/add/formats/list/{$id}";
			$this->data['pagenavs'] = array(
				array("", 'Add Book Formats')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
		}

		$formats = array();
		
		if ($q = $this->db->order_by('seq', 'asc')->get('formats')) {
			
			if ($q->num_rows()) {
				
				foreach($q->result_object() as $r) {
					
					$formats[$r->id] = $r->name;
				}
			}
		}

		$options->maps = array(
			array('label' => 'Book Format', 'db'=>'format_id', 'type'=>'dropdown', 'values'=>$formats), 

			array('label' => 'BISAC', 'db'=>'bisac'),
			
			array('label' => '# ISBN-13', 'db'=>'isbn13'),
			array('label' => '# ISBN-10', 'db'=>'isbn10'),
			
			array('label' => 'Price in USD $', 'db' => 'price', 'db_extra' => 'float'), 
			array('label' => 'Publication Date', 'db'=>'pub_date', 'rules'=>'trim', 'type'=>'date', 'date_extra'=> 'no_day'),

			array('label' => 'Pages', 'db' => 'pages'), 
			array('label' => 'Dimensions', 'db' => 'dimensions'),
			array('label' => 'hidden', 'db'=>'book_id', 'type' => 'hidden', 'def'=>$id)
		);


		$this->tabs['formats']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		$this->_add($options);
	}
	
	function book_formats_edit($type, $id, $format_id) {

		$options = new stdClass;

		$options->tbl = 'book_formats';
		$options->redirect_url = "/projects/list/edit/formats/list/{$id}";
		$options->force_redirect = 1;
		$this->data['category'] = (object) array('name' => 'Update Book');
		$this->data['pagenavs'] = array(
			array("", 'Update Book Format')
		);
		
		if ($type === 'add') {
		
			$options->tbl = 'temp_book_formats';	
			$options->redirect_url = "/projects/list/add/formats/list/{$id}";
			$this->data['pagenavs'] = array(
				array("", 'Update Book Format')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
		}

		$formats = array();
		
		if ($q = $this->db->order_by('seq', 'asc')->get('formats')) {
			
			if ($q->num_rows()) {
				
				foreach($q->result_object() as $r) {
					
					$formats[$r->id] = $r->name;
				}
			}
		}
		
		$options->maps = array(
			array('label' => 'Book Format', 'db'=>'format_id', 'type'=>'dropdown', 'values'=>$formats), 

			array('label' => 'BISAC', 'db'=>'bisac'),

			array('label' => '# ISBN-13', 'db'=>'isbn13'),
			array('label' => '# ISBN-10', 'db'=>'isbn10'),
			
			array('label' => 'Price in USD $', 'db' => 'price'), 
			array('label' => 'Publication Date', 'db'=>'pub_date', 'rules'=>'trim', 'type'=>'date', 'date_extra' => 'no_day'),

			array('label' => 'Pages', 'db' => 'pages'), 
			array('label' => 'Dimensions', 'db' => 'dimensions'),
			array('label' => 'hidden', 'db'=>'book_id', 'type' => 'hidden', 'def'=>$id)
		);


		$this->tabs['formats']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		
		$options->id->val = $format_id;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
				
		$this->_edit($options);
	}

	function book_formats_delete($type, $id, $format_id) {

		$options = new stdClass;
		$options->id->val = $format_id;
		$options->redirect_url = "/projects/list/edit/formats/list/{$id}";
		$options->tbl = 'book_formats';

		if ($type === 'add') {
			
			$options->redirect_url = "/projects/list/add/formats/list/{$id}";
			$options->tbl = 'temp_book_formats';
		}

		$this->_delete($options);
	}
	
	
	
	
	function book_edit_description($type, $id) {

		$options = new stdClass;

		$options->redirect_url = '/projects/list';
		$options->tbl = 'books';
		$tbl_genres = 'book_genres';
		
		$this->data['pagenavs'] = array(
			array("", 'Update Description')
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		$this->data['factions'] = array(array("/projects/list/delete/{$id}", 'Delete'));			
	
		if ($type === 'add') {
			
			$options->tbl = "temp_books";
			$this->data['pagenavs'] = array(
				array("", 'Add Description')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
			$this->data['factions'] = array(array("/projects/publish/{$id}", "Publish"));
			$tbl_genres = 'temp_book_genres';
		}
		
		$age_ranges = array();

		if ($ranges = $this->db->order_by('seq', 'asc')->get('age_ranges')) {

			foreach($ranges->result_object() as $r) {
				
				$age_ranges[$r->id] = $r->description;
			}
		}
		
		$genres = array();
		
		if ($q = $this->db->order_by('name', 'asc')->get('genres')) {
		
			foreach($q->result_object() as $r) {
			
				$genres[$r->id] = $r->name;	
			}
		}
		
		$saved_genres = array();
		
		if ($q = $this->db->get_where($tbl_genres, array('book_id' => $id))) {
			
			foreach($q->result_object() as $r) {

				$saved_genres[] = $r->genre_id;			
			}
		}
		
		$options->maps = array(
			array('label' => 'Age Range', 'db'=>'age_range', 'type'=>'dropdown', 'values'=>$age_ranges,  'sep' => 1, 'rules' => 'trim'),
			array('label' => 'Genre(s)', 'db'=>'genres[]','type'=>'checkbox', 'values'=>$genres, 'defs' => $saved_genres,
					'skip_write'=>1, 'sep'=>1),
			array('label' => 'Character Traits', 'db'=>'traits','sep'=>1, 'rules' => 'trim'),

			array('label' => 'Description', 'db'=>'description','type'=>'textarea', 'rules' => 'trim'),
		);
		
		$options->skip_writes = array(
			(object)array(
				'tbl' => $tbl_genres,
				'fk'=> 'book_id',
				'fk_val'=> $id,
				'col' => 'genre_id',
				'fld' => 'genres[]'
			)
		);

		$options->id = (object) ['val' => $id];
		$this->tabs['description']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		$this->data['submit'] = 'Save Description';

		$this->_edit($options);
	}
	

	function book_edit_resources($type, $id) {

		$options = new stdClass;

		$options->redirect_url = '/projects/list';
		$options->tbl = 'books';
		$this->data['pagenavs'] = array(
			array("", 'Update Resources')
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		$this->data['factions'] = array(array("/projects/list/delete/{$id}", 'Delete'));			

		if ($type === 'add') {
			
			$options->tbl = "temp_books";
			$this->data['pagenavs'] = array(
				array("", 'Add Resources')
			);
			
			$this->data['category'] = (object) array('name' => 'Add Book');
			$this->data['factions'] = array(array("/projects/publish/{$id}", "Publish")); 
		}
				
		$options->maps = array(
			array('label' => 'Guided Reading Levels', 'db'=>'guided_reading_levels', 'section'=>'Reading Level', 'rules' => 'trim'),
			array('label' => 'Lexile', 'db'=>'lexile', 'rules' => 'trim'),
			array('label' => 'Fountas &amp; Pinell', 'db'=>'fountas','sep'=>1, 'rules' => 'trim'),

			array('label' => 'Accelerated Reader', 'db'=>'accelerated', 'section'=>'Quiz Numbers', 'rules' => 'trim'),
			array('label' => 'Reading Counts', 'db'=>'reading_counts','sep'=>1, 'rules' => 'trim'),

			array('label' => 'File 01', 'db'=>'file1', 'rules'=>'trim', 'type'=>'file', 'section'=>'Supplementary Downloads'),
			array('label' => '', 'db'=>'file1_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'file1'),
			array('label' => 'Description', 'db'=>'description1', 'rules'=>'trim','sep_blank'=>1),

			array('label' => 'File 02', 'db'=>'file2', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'file2_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'file2'),
			array('label' => 'Description', 'db'=>'description2', 'rules'=>'trim', 'sep_blank' =>1),

			array('label' => 'File 03', 'db'=>'file3', 'rules'=>'trim', 'type'=>'file'),
			array('label' => '', 'db'=>'file3_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'file3'),
			array('label' => 'Description', 'db'=>'description3','rules'=>'trim')
		);

		$options->id = (object) ['val' => $id];
		$this->tabs['resources']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;

		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		$this->data['submit'] = 'Save Resources';
		
		$this->_edit($options);
	}
	
	function book_edit_images($type, $id) {

		$options = new stdClass;

		$options->redirect_url = '/projects/list';
		$options->tbl = 'books';
		$this->data['pagenavs'] = array(
			array("", 'Update Images')
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		$this->data['factions'] = array(array("/projects/list/delete/{$id}", 'Delete'));			

		if ($type === 'add') {
			
			$options->tbl = "temp_books";
			$this->data['pagenavs'] = array(
				array("", 'Add Images')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
			$this->data['factions'] = array(array("/projects/publish/{$id}", "Publish")); 
		}
				
		$options->maps = array(
			array('label' => 'Cover Thumb', 'db'=>'cover_thumb', 'rules'=>'trim', 'type'=>'file', 'note' => '95px wide'),
			array('label' => '', 'db'=>'cover_thumb_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'cover_thumb'),

			array('label' => 'Cover Medium', 'db'=>'cover_medium', 'rules'=>'trim', 'type'=>'file', 'note' => '310px wide'),
			array('label' => '', 'db'=>'cover_medium_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'cover_medium'),

			array('label' => 'Cover Large', 'db'=>'cover_large', 'rules'=>'trim', 'type'=>'file', 'sep'=>1, 'note' => 'No taller than 600px, No wider than 900px'),
			array('label' => '', 'db'=>'cover_large_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'cover_large'),

			array('label' => 'Image 01', 'db'=>'image1', 'rules'=>'trim', 'type'=>'file', 'note' =>'No taller than 600px, No wider than 900px'),
			array('label' => '', 'db'=>'image1_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'image1'),

			array('label' => 'Image 02', 'db'=>'image2', 'rules'=>'trim', 'type'=>'file', 'note' =>'No taller than 600px, No wider than 900px'),
			array('label' => '', 'db'=>'image2_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'image2'),

			array('label' => 'Image 03', 'db'=>'image3', 'rules'=>'trim', 'type'=>'file', 'note' =>'No taller than 600px, No wider than 900px'),
			array('label' => '', 'db'=>'image3_track', 'rules'=>'callback__validate_file_optional', 'type'=>'hidden',
					'skip_write' => 1, 'def' => 'image3')
		);

		$options->id = (object) ['val' => $id];

		$this->tabs['images']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		$this->data['submit'] = 'Save Images';
		
		$this->_edit($options);
	}

	function book_edit_purchase($type, $id) {

		$options = new stdClass;

		$options->redirect_url = '/projects/list';
		$options->tbl = 'books';
		$this->data['pagenavs'] = array(
			array("", 'Update Purchase Links')
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		$this->data['factions'] = array(array("/projects/list/delete/{$id}", 'Delete'));			

		if ($type === 'add') {
			
			$options->tbl = "temp_books";
			$this->data['pagenavs'] = array(
				array("", 'Add Purchase Links')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
			$this->data['factions'] = array(array("/projects/publish/{$id}", "Publish")); 
		}
				
		$options->maps = array(
			array('label' => 'aStore', 'db' => 'buy_astore', 'rules' => 'trim'), 
			array('label' => 'Barnes &amp; Noble', 'db' => 'buy_barnes', 'rules' => 'trim'), 
			array('label' => "Border's", 'db' => 'buy_borders', 'rules' => 'trim'), 
			array('label' => 'IndieBound', 'db' => 'buy_indiebound', 'rules' => 'trim'), 
			array('label' => 'iPhone + Ipad App', 'db' => 'buy_iphone', 'rules' => 'trim') 
		);

		$options->id = (object) ['val' => $id];

		$this->tabs['purchase']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		$this->data['submit'] = 'Save Purchase Links';
		
		$this->_edit($options);
	}
	
	

	function book_reviews_list($type, $id, $filter = 'editor') {
		
		$url_prefix = "/projects/list/edit/reviews/list/{$id}";
		$tbl = "reviews";

		$this->data['pagenavs'] = array(
			array("", "Update Book Reviews")
		);
		
		$this->data['category'] = (object) array('name' => 'Update Book');
		
		if ($type === 'add') {

			$url_prefix = "/projects/list/add/reviews/list/{$id}";
			$tbl = 'temp_reviews';
			$this->data['pagenavs'] = array(
				array("", 'Add Book Reviews')
			);

			$this->data['category'] = (object) array('name' => 'Add Book');
		}

		$this->data['tabnavs'] = array(
			array("{$url_prefix}/add", 'Add Editorial Review'),
			array("{$url_prefix}/editor", 'Editorial Reviews'),
			array("{$url_prefix}/member", 'Member Reviews'),
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/[id]", 'map' => 'full_name'),
			(object)array('cls'=>'gactions', 'width'=> '15%',  'url'=> "{$url_prefix}/delete/[id]", 'title' => 'delete')
		);

		$s = "
			select
				{$tbl}.id,
				{$tbl}.rating,
				{$tbl}.description,
				(case when members.id then concat(lastname, ', ', firstname) else 'Editor' end ) as full_name 
			from
				{$tbl} left join members on (members.id = {$tbl}.member_id)
			where
				book_id = {$id} and
				member_id != 0 and
				status = 1
		";
		
		if ($filter == 'editor') {

			$s = "
				select
					*
				from
					{$tbl}
				where
					book_id = {$id} and
					member_id = 0
			";
		}
		
		$this->data['url_prefix'] = $url_prefix;
		$this->data['listQ'] = $this->db->query($s);
		$this->tabs['reviews']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		
		$this->_list("list_reviews_{$filter}");
	}


	function book_reviews_add($type, $id) {

		$options = new stdClass;

		$options->tbl = 'reviews';
		$options->redirect_url = "/projects/list/edit/reviews/list/{$id}";
		$this->data['pagenavs'] = array(
			array("", 'Update Book Reviews')
		);
		$this->data['category'] = (object) array('name' => 'Update Book');
		
		if ($type === 'add') {
		
			$options->tbl = 'temp_reviews';	
			$options->redirect_url = "/projects/list/add/reviews/list/{$id}";
			$this->data['pagenavs'] = array(
				array("", 'Add Book Review')
			);
			$this->data['category'] = (object) array('name' => 'Add Book');
		}

		$options->maps = array(
			array('label' => 'Review', 'db'=>'description', 'type'=>'textarea'),
			array('label' => 'hidden', 'db'=>'member_id', 'type'=>'hidden','def'=>0),
			array('label' => 'hidden', 'db'=>'book_id', 'type' => 'hidden', 'def'=>$id)
		);


		$this->tabs['reviews']['active'] = TRUE;
		$this->data['tabs'] = $this->tabs;
		$this->data['id'] = $id;
		$this->data['action_type'] = $type;
		$this->_add($options);
	}


	function book_reviews_delete($type, $id, $review_id) {

		$options = new stdClass;
		
		$q = $this->db->get_where('reviews', array('id'=>$review_id));
		$suffix = 'editor';
		
		if ($q->num_rows()) {
		
			$r = $q->row();
			
			if ($r->member_id) {
				
				$suffix = 'member';
			}
		}
		
		$options->id->val = $review_id;
		$options->redirect_url = "/projects/list/edit/reviews/list/{$id}/{$suffix}";
		$options->tbl = 'reviews';

		if ($type === 'add') {
			
			$options->redirect_url = "/projects/list/add/reviews/list/{$id}/{$suffix}";
			$options->tbl = 'temp_reviews';
		}

		$this->_delete($options);
	}	
	


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function all_list() {

		$url_prefix = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("/projects/list/add", 'Add Book')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'book title', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/details/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label'=> 'author','width'=> '25%', 'map' => 'author')
		);
		
		$s = "
			select
				*
			from
				books
			order by
				title asc
		";
		
		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}


	function featured_list() {

		$url_prefix = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("/projects/list/add", 'Add Book')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'book title', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/details/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label'=> 'author','width'=> '25%', 'map' => 'author')
		);
		
		$s = "
			select
				*
			from
				books
			where
				featured = 1
			order by
				title asc
		";
		
		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}

	function releases_list() {

		$url_prefix = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("/projects/list/add", 'Add Book')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label' => 'book title', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/details/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label' => 'author', 'width'=> '25%', 'map' => 'author')
		);
		
		$s = "
			select
				*
			from
				books
			where
				new_release = 1
			order by
				title asc
		";

		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}


	function bestsellers_list() {

		$url_prefix = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("/projects/list/add", 'Add Book')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'book title', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/details/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label' => 'author','width'=> '25%', 'map' => 'author')
		);
		
		$s = "
			select
				*
			from
				books
			where
				bestseller = 1
			order by
				title asc
		";

		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}

	function teaching_list() {

		$url_prefix = '/projects/list';
		
		$this->data['pagenavs'] = array(
			array("/projects/list/add", 'Add Book')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label'=>'book title', 'width'=> '50%', 'url'=> "{$url_prefix}/edit/details/[id]", 'map' => 'title'),
			(object)array('cls'=>'gtitle', 'label' => 'author','width'=> '25%', 'map' => 'author')
		);
		
		$s = "
			select
				*
			from
				books
			where
				teaching_guide = 1
			order by
				title asc
		";

		$this->data['listQ'] = $this->db->query($s);
		
		$this->_list();
	}
		
	

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function categories_list() {
        
        die('got here');

		$url_prefix = '/projects/categories/list';
		
		$this->data['pagenavs'] = array(
			array("{$url_prefix}/add", 'Add Category')
		);
		
		$this->data['listDefs'] = array(
			(object)array('cls'=>'gtitle', 'label' => 'name',  'width'=> '50%', 'url'=> "{$url_prefix}/edit/[id]", 'map' => 'name'),
			(object)array('cls'=>'gactions',  'width'=> '15%',  'url'=> "{$url_prefix}/delete/[id]", 'title' => 'delete')
		);
		
		$this->db->order_by('seq asc');
		$this->data['listQ'] = $this->db->get('project_categories');
		
		$this->_list();
	}
	
	function categories_add() {

		$options = new stdClass;

		$options->tbl = 'project_categories';
		$options->redirect_url = '/projects/categories/list';
		$options->maps = array(
			array('label' => 'Name', 'db'=>'name')
		);

		$this->data['pagenavs'] = array(
			array("", 'Add Category')
		);
		
		$this->data['category'] = (object) array('name' => 'Categories');
		$this->_add($options);
		
	}
	
	function categories_edit($id) {

		$options = new stdClass;

		$options->redirect_url = '/projects/categories/list';
		
		$options->tbl = 'project_categories';
		$options->maps = array(
			array('label' => 'Name', 'db'=>'name')
		);

		$this->data['pagenavs'] = array(
			array("", 'Update Category')
		);
		
		$options->id = (object) ['val' => $id];
		$this->data['category'] = (object) array('name' => 'Categories');
				
		$this->_edit($options);
	}

	function categories_delete($id) {

		$options = new stdClass;
		$options->id = (object) ['val' => $id];
		$options->redirect_url = '/projects/categories/list';
		$options->tbl = 'project_categories';
		$this->_delete($options);
	}
	
		
	



}