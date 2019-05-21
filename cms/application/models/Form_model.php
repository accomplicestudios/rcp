<?php

class Form_model extends CI_Model {
	
	public $tbl = '';
	public $maps = array();
	public $record = NULL;
	public $id = NULL;
	public $redirect_url = '';
	
	public $uploads = NULL;
	public $skip_writes = NULL;
	public $rules_setup = NULL;
	
	function __construct() {
		
		parent::__construct();
		$this->id = new stdClass(); 
		$this->id->key = 'id';
	}
	
	function setup($options) {

		if (isset($options->id)) {

			$this->id->key = !empty($options->id) && !empty($options->id->key) ? $options->id->key : $this->id->key;
			$this->id->val = !empty($options->id) && !empty($options->id->val) ? $options->id->val : 0;
		}
		
		$this->tbl = $options->tbl;	

		foreach($options->maps as $k => $v) {

			$this->maps[$v['db']] = $v;
		}

		//$this->maps = $options->maps;
		
		foreach($this->maps as $key=>$val) {
			
			$val = (object)$val;
			
			if (empty($val->type)) {
				
				$this->maps[$key]['type'] = 'text';
			}
		}
		
		$this->skip_writes = !empty($options->skip_writes) ? $options->skip_writes : '';
		$this->redirect_url = !empty($options->redirect_url) ? $options->redirect_url : '';
		$this->rules_setup = !empty($options->rules_setup) ? $options->rules_setup : '';
	}
	
	function save() {
	
		$record = new stdClass();

		if (!empty($this->skip_writes)) {
			
			foreach($this->skip_writes as $k => $cfg) {
				
				$this->db->delete($cfg->tbl, array($cfg->fk => $cfg->fk_val));
				
				$cfg->fld = str_replace('[]', '', $cfg->fld);
				
				if (isset($_POST[$cfg->fld])) {

					$val = $_POST[$cfg->fld];
					$val_sql = array();
					
					if (is_array($val)) {
						
						foreach($val as $vk => $v) {
							
							$val_sql[] = "
								(
									'{$cfg->fk_val}',
									'{$v}'
								)
							";
						}
					}
					else {
						
						$val_sql[] = "
							(
								'{$cfg->fk_val}',
								'{$val}'
							)
						";
					}
					
					$val_sql = implode(',', $val_sql);
					
					$s = "
						insert into
							{$cfg->tbl}
						(
							{$cfg->fk},
							{$cfg->col}
						)
						values
							{$val_sql}
					";
					
					$this->db->query($s);	
				}
			}
		}
		
		$skipped_values = array();
		
		foreach($this->maps as $key => $val) {
			
			$val = (object)$val;
			
			if (!empty($val->skip_write)) {
				
				continue;
			}

			if ($val->type === 'date') {
			
				if ($this->input->post($val->db."_month") &&
					$this->input->post($val->db."_day") &&
					$this->input->post($val->db."_year")) {
					
					$record->{$val->db} = date('Y-m-d',
						mktime(0, 0, 0,
							$this->input->post($val->db . '_month'),
							$this->input->post($val->db . '_day'),
							$this->input->post($val->db . '_year')
						)
					);
				}
				else {
					
					$record->{$val->db} = '0000-00-00';
				}
			}
			else if ($val->type === 'multiselect') {

				$skipped_values[$key] = $this->input->post($val->db);
				
				if (empty($skipped_values[$key])) {
					
					$skipped_values = array();
				}
			}
			else if ($val->type === 'file') {

				if (!empty($val->upload_data)) {
					
					$record->{$val->db} = $val->upload_data['file_name'];
				}
			}
			else if ($val->type === 'checkbox' && strstr($val->db, "[]")) {
				
				// __peek($this->input->post($val->db));
			}
			else if ($val->type === 'check') {

				$record->{$val->db} = $this->input->post($val->db);
				empty($record->{$val->db}) && $record->{$val->db} = 0; 
			}
			else {

				if (!empty($val->db_extra)) {
				
					$record->{$val->db} = number_format($this->input->post($val->db), 5, '.', '');	
				}
				else {
					
					$record->{$val->db} = $this->input->post($val->db);
				}
			}
			
		}
		
		if (isset($this->id, $this->id->val)) {

			if (!empty($skipped_values)) {
				
				foreach($skipped_values as $key=>$val) {
					
					$map = (object)$this->maps[$key];
					
					$this->db->where($map->key, $map->keyval);
					$this->db->delete($map->tbl);
					
					foreach($val as $k=>$v) {
						
						$this->db->insert($map->tbl,
							array(
								$map->key => $map->keyval,
								$map->col => $v
							)
						);
					}
				}
			}

			$this->db->where($this->id->key, $this->id->val);
			
			if (!empty($record)) {

				return $this->db->update($this->tbl, $record);
			}
			
			return TRUE;
		}
		else {

			if ($this->db->insert($this->tbl, $record)) {

				$this->id->key = 'id';
				$this->id->val = $this->db->insert_id();
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	function delete() {
	
		$this->db->where($this->id->key, $this->id->val);
		$q = $this->db->delete($this->tbl);
		
		if ($q) {
			
			$this->session->set_flashdata('deleted', 1);
		}
		
		return $q;
	}
	
	function get() {
		
		$this->record = array();
		$q = $this->db->get_where($this->tbl, array($this->id->key => $this->id->val));
		
		if ($q->num_rows()) {
			
			$r = $q->row();
			
			foreach($this->maps as $val) {

				$val = (object)$val;

				if (empty($val->skip) && empty($val->skip_write)) {
				
					$this->record[$val->db] = $r->{$val->db};	
				}
				else {
					
					//if ($val->type != 'file') {	
					//	
					//	$qS = $this->db->get_where($val->tbl, array($val->key => $val->keyval));
					//	$this->record[$val->db] = array();
					//	
					//	foreach($qS->result_object() as $skipR) {
					//		
					//		$this->record[$val->db][] = $skipR->{$val->col};
					//	}
					//}
				}
			}
			
			$this->record[$this->id->key] = $r->{$this->id->key};
		}
	}
	
	function rules() {
		
		$rules = array();
		
		foreach($this->maps as $val) {
			
			if (!empty($val->skip)) {
				continue;
			}
			
			$val = (object) $val;			
			
			$rule = array();
			$rule['field'] = $val->db;
			$rule['label'] = isset($val->label) ? $val->label : ''; // hidden _track fields don't have labels!
			$rule['rules'] = !empty($val->rules) ? $val->rules : 'trim|required';

			$rules[] = $rule;
		}

		if (!empty($this->rules_setup)) {
		
			$this->{$this->rules_setup}($rules);
		}

		return $rules;
	}
	
	
	function setup_rules_updates(&$rules) {
		
		$type = $this->input->post('type_id');

		if ($type == '23') { // text

			$this->set_rule_by_name('name', 'trim|required', $rules);		
			$this->set_rule_by_name('image1_track', 'callback__validate_file_optional', $rules);
		}
		else if ($type == '24') { // photo
			
			$this->set_rule_by_name('name', 'trim', $rules);
			$this->set_rule_by_name('image1_track', 'callback__validate_file_required', $rules);
		}
		else if ($type == '25') { // calendar

			$this->set_rule_by_name('name', 'trim|required', $rules);		
			$this->set_rule_by_name('image1_track', 'callback__validate_file_optional', $rules);
		}
	}
	
	
	function set_rule_by_name($field_name, $final_rule, &$rules){

		foreach($rules as $k => $rule) {
			
			if ($rule['field'] == $field_name) {
			
				$rules[$k]['rules'] = $final_rule;
			}
		}
		
		return FALSE;
	}
	
	function delete_file() {
		
		$key = $this->input->post('key');
		$record[$key] = '';
		
		$this->db->where($this->id->key, $this->id->val);
		return $this->db->update($this->tbl, $record);
	}
}