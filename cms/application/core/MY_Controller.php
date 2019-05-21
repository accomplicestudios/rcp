<?php 

class MY_Controller extends CI_Controller {
	
	public $data = array();
	private $upload_cfg = array();
	protected $options = NULL;
	protected $tabs = array();
	
	function __construct() {

		parent::__construct();

		$this->data['navs'] = $this->navs_model->roster();
		$this->data['section_url'] = $this->uri->segment(1);
		$this->data['category_url'] = rtrim(implode('/', array_slice(explode('/', $this->uri->uri_string()),2)), '/');
		
		$this->data['section'] = $this->navs_model->section_uri($this->data['section_url']);
		
		if ($this->data['section']) {
			$this->data['category'] = $this->navs_model->category_uri($this->data['category_url'], $this->data['section']->id);
		}
		
		// default list record id
		// we can override this in each controller
		$this->data['listID'] = 'id';
		
	}
	
	function view($viewfile) {
		
		$this->load->view('_header', $this->data);
		$this->load->view($viewfile, $this->data);
		$this->load->view('_footer', $this->data);
	}
	
	function _overview($code) {

		$this->load->model('overview_model');
		$this->overview_model->get($code);
		
		$this->data['description'] = $this->overview_model->description;
		$this->data['date_modified'] = $this->overview_model->date_modified;
		
		form_rules(array(
			array('description', 'Overview')
		));
		
		if ($this->form_validation->run()) {
			
			$this->overview_model->code  = $code;
			$this->overview_model->description = $this->input->post('description');
			$this->overview_model->save();
			
			$this->data['success'] = TRUE;
		}
		else {
			$this->data['errors'] = validation_errors();
		}
		

		$this->view('overview', $this->data);
		
	}
	
	function _list($list_file = 'list') {

		$this->view($list_file, $this->data);
	}
	
	function _sort($options, $col = 'seq') {

		if ($items = $this->input->post('items')) {
		
			$items = str_replace(';', '', $items);
			parse_str($items);

			if (!empty($item)) {
				
				$start = count($item);
				
				foreach($item as $k => $v) {
					
					$record[$col] = $k + 1;
					$this->db->where('id', $v);
					isset($options->where) && $this->db->where($options->where); 
					$this->db->update($options->tbl, $record);
				}	
			}
			
			$this->data['sorted'] = TRUE;
		}
		
		if (empty($this->data['force_query'])) {

			if (isset($options->where)) {
				
				$this->db->where($options->where);
			}
			
			$this->db->order_by($options->order_by);
			$this->data['listQ'] = $this->db->get($options->tbl);
		}
		else {
			
			$this->data['listQ'] = $this->db->query($this->data['force_query']);
		}
		
		$this->data['sortable_cls'] = isset($options->sortable_cls) ? $options->sortable_cls : '';

		$this->data['redirect_url'] = $options->redirect_url;
		$this->view('sort', $this->data);
	}
	
	function _add($options) {
		
		$this->load->model('form_model');
		$this->form_model->setup($options);
		
		$this->form_validation->set_rules($this->form_model->rules());
		$this->db->trans_begin();
		
		if ($this->form_validation->run()) {

			
			if ($this->form_model->save()) {

				if (!empty($this->form_model->id) && !empty($this->form_model->id->val)) {
						
					$this->_post_add($this->form_model->id->val, $options->tbl ?? '');
					$this->form_model->redirect_url = str_replace('[id]', $this->form_model->id->val, $this->form_model->redirect_url);
				}
				
				$this->db->trans_commit();
				redirect($this->form_model->redirect_url);
				exit;			
			}
		}
		else {
			$this->data['errors'] = validation_errors();			
		}
		
		$this->data['maps'] = $this->form_model->maps;
		$this->data['redirect_url'] = $options->redirect_url;
		isset($options->cancel_url) && $this->data['redirect_url'] = $options->cancel_url; 

		$this->view('add', $this->data);
		
		$this->db->trans_rollback();
	}
	
	function _edit($options) {
	
		$this->load->model('form_model');
		$this->form_model->setup($options);
		
		$this->form_validation->set_rules($this->form_model->rules());
		
		$deletefile = $this->input->post('act');
		
		if (!empty($deletefile)) {
			
			$this->form_validation->run();
			
			$this->form_model->delete_file();
			$this->data['success'] = TRUE;
		}
		else {
			
			if ($this->form_validation->run()) {
			
				if ($this->form_model->save()) {
					
					$this->data['success'] = TRUE;
					$this->form_model->get();
					
					$this->_post_update($this->form_model->id->val, $options->tbl ?? '');
					
					if (isset($options->force_redirect) && !empty($options->force_redirect)) {

						$redirect_url = $options->redirect_url;
						isset($options->force_redirect_url) && $redirect_url = $options->force_redirect_url;
						
						redirect($redirect_url);exit;
					}
				}
			}
			else {
				
				$errors = validation_errors();
				if (!empty($errors)) {
	
					$this->data['errors'] = $errors;		
				}
			}
		}

		$this->form_model->get();
		$this->data['maps'] = $this->form_model->maps;
		$this->data['redirect_url'] = $options->redirect_url;
		$this->data['action_type'] = 'edit';
		$this->view('edit', $this->data);
	}
	
	function _delete($options) {
				
		$this->load->model('form_model');
		$this->form_model->id->val = $options->id->val;
		$this->form_model->tbl = $options->tbl;
		$this->form_model->delete();
		
		if (property_exists($options, 'post_delete')) {

			$this->db->query($options->post_delete);
		}

		redirect($options->redirect_url);
	}


	function _send($options) {
		
		$this->load->model('form_model');
		$this->form_model->setup($options);
		
		$this->form_validation->set_rules($this->form_model->rules());
		
		if ($this->form_validation->run()) {
			
			ini_set('max_execution_time', 0);
			$this->load->library('email');
			
			$q = $this->db->get('members');
			
			foreach($q->result_object() as $r) {
				
				$config = array('mailtype'=>'html');
				$this->email->initialize($config);
				
				$this->email->clear();
				$this->email->from('no-reply@mrmfuture.com', 'TigerTales');
				$this->email->subject($this->input->post('subject'));
				$this->email->message($this->input->post('message'));
		
				$this->email->to($r->email);
	
				$this->email->send();
				$this->data['success'] = TRUE;
			}
		}
		else {
			
			$this->data['errors'] = validation_errors();
		}
		
		$this->data['maps'] = $this->form_model->maps;
		$this->data['redirect_url'] = $options->redirect_url;
		$this->view('add', $this->data);
	}
	

	function _validate_file_required($fld_name) {

		$this->load->library('upload');
		$fld_label = $this->form_model->maps[$fld_name]['label'];
			
		if ($this->upload->do_upload($fld_name)) {

			$this->form_model->maps[$fld_name]['upload_data'] = $this->upload->data();
			return TRUE;
		}
		else {

			if (isset($_FILES[$fld_name]) && $_FILES[$fld_name]['size'] == 0) {
				$this->form_validation->set_message(__FUNCTION__, "The {$fld_label} is required.");
				$errors = $this->upload->display_errors('', '');
				$this->upload->error_msg = array();
				return FALSE; 
			}
		}

		$errors = $this->upload->display_errors('', '');
		$this->upload->error_msg = array();
		$this->form_validation->set_message(__FUNCTION__, "{$fld_label}: {$errors}");

		return FALSE; 
	}

	function _validate_file_optional($fld_name) {

		$this->load->library('upload');
		$fld_label = $this->form_model->maps[$fld_name]['label'];
		
		if ($this->upload->do_upload($fld_name)) {

			$this->form_model->maps[$fld_name]['upload_data'] = $this->upload->data();
			return TRUE;
		}
		else {
			
			if (isset($_FILES[$fld_name]) && $_FILES[$fld_name]['size'] == 0) {
				// IT IS OPTIONAL SO WE SKIP
				return TRUE; 
			}
		}
						
		$errors = $this->upload->display_errors('', '');
		$this->upload->error_msg = array();
		$this->form_validation->set_message(__FUNCTION__, "{$fld_label}: {$errors}");
		return FALSE;
	}
	
	function _validate_date_required($val, $fld_name) {

		$year = $this->input->post($fld_name . '_year');
		$month = $this->input->post($fld_name . '_month'); 
		$day = $this->input->post($fld_name . '_day');

		if (empty($year) || empty($month) || empty($day)) {

			$this->form_validation->set_message(__FUNCTION__, "The %s field is not a valid date.");
			return FALSE; 
		}

		return TRUE; 
	}


	function _active_tab($str) {

		$this->data['tabs'][$str]['active'] = TRUE;
	}
	
	function _publish($tbl, $id, $redirect_url) {

		$fields = $this->db->list_fields($tbl);
		$fields = array_diff($fields, array('id'));
		$fields = implode(',', $fields);
		$id = $this->db->escape_str($id);
		
		$s = "
			INSERT INTO
				{$tbl}
			(
				{$fields}
			)
			SELECT
				{$fields}
			FROM
				{$tbl}_temp
			WHERE
				id = '{$id}'
		";
		
		if ($this->db->query($s)) {
		
			redirect($redirect_url . $this->db->insert_id());
			exit;
		}
	}
	
	function _name($tbl, $id, $col) {

		return $this->_field($tbl, $id, $col);		
	}
	
	function _field($tbl, $id, $col) {

		if ($q = $this->db->get_where($tbl, array('id' => $id))) {
			
			if ($r = $q->row()) {
				
				return $r->$col;
			}
		}

		return FALSE;
	}
	function _pagename($tbl) {
		
		$tbl = str_replace('_temp', '', $tbl);
		return ucwords(singular($tbl));
	}
	
	function _temp($tbl, $redirect_url, $col = 'name') {

		$record = array($col => '', 'date_published' => date('Y-m-d'));
		$this->db->insert($tbl, $record);
		redirect($redirect_url . $this->db->insert_id(), 'refresh');
		exit;
	}
	
	protected function _post_add($id, $tbl) {
		
	}
	
	protected function _post_update($id, $tbl) {
		
		
	}
}