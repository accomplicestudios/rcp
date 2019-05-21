<?php 

function __peek($var) {
	
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	exit;
}

function show_home_nav($id) {

	$c =& get_instance();
	
	$section = $c->navs_model->section($id);
	$navs = $c->navs_model->cats($section->id);
	echo '<h1>'. $section->name . '</h1>';
	echo '<ul class="navi">';

	$main_url = '/' . $section->url;
	
	$i = 1;
	foreach($navs->result_object() as $nav) {

		
		$next_nav = @$navs->next_row();
		
		if ($nav->type == 'normal') {
			
			$style = "";
			
			if (!empty($next_nav) && $next_nav->type == 'divider') {
				
				$style = 'style="padding-bottom: 5px"';	
			}
			
			echo '<li><a  ' . $style . ' href="' . $main_url . '/' . $nav->url . '">+ ' . $nav->name . '</a></li>'; 			
		}
		else if ($nav->type == 'divider') {
			
			echo '<li style="border:0;min-height:8px"></li>';
		}
		else if ($nav->type == 'sub') {
			
			echo '<li class="sub"><span class="subheader">' . $nav->name . '</span></li>';
			expander($nav, $nav->expander, 'name', $main_url, 'home');
		}
		else if ($nav->type == 'blank'){
			
			expander($nav, $nav->expander, 'name', $main_url, 'home');
		}
	}
	
	echo '</ul>';
}

function setup_rules($configs) {
	
	$rules = array();
	
	foreach($configs as $config) {
		
		$rules[] = array(
			'field' => $config[0],
			'label' => $config[1],
			'rules' => isset($config[2]) ? $config[2] : 'trim|required'
		);
	}
	
	return $rules;
}

function form_rules($configs) {
	
	$c =& get_instance();
	$rules = setup_rules($configs);
	$c->form_validation->set_rules($rules);

}

function form_data($fields) {
	
	$c =& get_instance();
	$record = array();
	
	foreach($fields as $key=>$field) {

		$record[$field] = $c->input->post($field);		
	}
	
	return $record;
}

function show_success($success, $message, $width = 0) {
	
	if ($success) {

		return '<div id="successbox" style="' . ($width ? 'width: ' . $width : '') . 'px">' . $message . '</div>';
	}
}

function show_errorbox($error, $message, $width = 0) {
	
	if ($error) {

		return '<div id="errorbox" style="' . ($width ? 'width: ' . $width : '') . 'px">' . $message . '</div>';
	}
}

function date_months() {
	
	return array(
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December'
	);
}

function date_days() {

	$temp = range(0, 31);
	unset($temp[0]);
	return $temp;
}

function date_years() {
	
	$temp = array();

	$max_years = date('Y') + 5;
	
	for($i=2019; $i<=$max_years; ++$i) {
		
		$temp["$i"] =$i;
	}

	return $temp;
}

function draw_tabs($tabs, $id, $type = 'add') {
	
	
	if (!empty($tabs)) { 

		echo '<ul class="tabs">';
		foreach($tabs as $k => $v) {

			$v = (object)$v;
			$tab_link = "<span>{$v->name}</span>";
			$li_class = "";
			
			if (!empty($v->active)) {
				
				$li_class = "activ";
			}
			else {
				
				$url = str_replace('[id]', $id, $v->$type);
				$tab_link = "<a href=\"{$url}\">" . $tab_link . "</a>";
			}

			echo "<li class=\"{$li_class}\">{$tab_link}</li>";
		}
		
		echo "</ul>";
	}		
}

function draw_action_navs($pagenavs) {

	echo '<p class="actionnavs" style="width: 100%">';
	
	$navs_array = array();
	
	foreach($pagenavs as $pagenav) { 
				
		if (empty($pagenav[0])) {
					
			$navs_array[] = "<span>{$pagenav[1]}</span>";
		}
		else {
			
			$navs_array[] = "<a href=\"{$pagenav[0]}\">{$pagenav[1]}</a>";
		}
	}
			
	echo implode(' ', $navs_array);			
	echo "</p>";
}

function draw_page_navs($pagenavs, $loc = 'left', $nav_right_empty = TRUE) {

	$style = "";
	
	if ($nav_right_empty) {
		
		$style = 'style="width: 100%"';
	}
	echo "<p class=\"pagenavs_{$loc}\" {$style}>";
	
	$navs_array = array();
	
	foreach($pagenavs as $pagenav) { 
				
		if (empty($pagenav[0])) {
					
			$navs_array[] = "<span>{$pagenav[1]}</span>";
		}
		else {
			
			$navs_array[] = "<a href=\"{$pagenav[0]}\" target=\"" . @$pagenav[2] . "\">{$pagenav[1]}</a>";
		}
	}
			
	echo implode(' | ', $navs_array);			
	echo "</p>";
}

function draw_input($map, $edit = FALSE) {
	
	$c =& get_instance();
	
	$default = isset($c->form_model->record) ? (isset($c->form_model->record[$map->db]) ? $c->form_model->record[$map->db] : '') : '';
	$form_value = set_value($map->db);
	$default = !empty($form_value) ? $form_value : $default;

	$sep = "";
	
	if (!empty($map->sep)) {
		
		$sep = '<div class="separ" />';
	}
	
	if (!empty($map->sep_blank)) {
		
		$sep = '<div class="separ_blank" />';
	}
	
	switch($map->type) {
	
		case 'text':
			
			$style = '';
			
			if (!empty($map->smalltext)) {
				$style = 'width: 20%';				
			}
			
			$default = isset($map->def) ? $map->def : $default;
			return form_input(array('name'=>$map->db, 'value'=>str_replace('"', '&quot;', set_value($map->db, $default)), 'style'=>$style)) . $sep;
		
		case 'textarea':
		
			return '<textarea name="' . $map->db . '">' . set_value($map->db, $default) . '</textarea>' . $sep;

		case 'date':
			
			$default_month = " ";
			$default_day = " ";
			$default_year = " ";
			$day_choices = date_days();
			$month_choices = date_months();
			$year_choices = date_years();
			
			if (isset($c->form_model->record)) {

				if (in_array($c->form_model->record[$map->db], array('1969-12-31', '0000-00-00'))) {
					
					$default_month = " ";
					$default_day = " ";
					$default_year = " ";
				}
				else {

					$temp = strtotime($c->form_model->record[$map->db]);
		
					$default_month = (int)date('m', $temp);
					$default_day = (int)date('d', $temp);
					$default_year = (int)date('Y', $temp);
				}
			}
			
			
			if (isset($map->allow_empty)) {

				$day_choices = ["" => ""] + $day_choices; 
				$month_choices = ["" => ""] + $month_choices; 
				$year_choices = ["" => ""] + $year_choices; 
			}

			$inputs = array();
			$inputs[] = form_dropdown($map->db . '_month', $month_choices, set_value($map->db .'_month', $default_month));
			
			if (!empty($map->date_extra) && $map->date_extra === 'no_day') {
				
				$inputs[] = form_hidden($map->db . '_day', 1);				
			}
			else {

				$inputs[] = form_dropdown($map->db . '_day', $day_choices, set_value($map->db . '_day', $default_day));
			}

			$inputs[] = form_dropdown($map->db . '_year', $year_choices, set_value($map->db . '_year', $default_year));
			
			return implode('&nbsp;', $inputs) . $sep;
	
		case 'dropdown':

			if (property_exists($map, 'query')) {
			
				$q = $c->db->query($map->query);
				$map->values = array();
				
				foreach($q->result_object() as $r) {
					
					if (isset($map->chained)) {

						$map->values[] = $r;
					}
					else {

						$map->values[$r->id] = $r->name; 	
					}
				}
			}
			
			if (property_exists($map, 'def_query')) {
				
				$q = $c->db->query($map->def_query);
				$default = $q->num_rows() ? $q->row()->{$map->db} : 0;
			}
			
			$id = isset($map->id) ? "id='{$map->id}'" : '';
			
			if (isset($map->chained)) {

				$dropdown = "<select id=\"{$map->id}\" name=\"{$map->db}\">";

				$value = set_value($map->db, $default);

				foreach($map->values as $k => $r) {
					
					$selected = $r->id === $value ? 'selected="selected"' : "";
					$dropdown .= "<option {$selected} value=\"{$r->id}\" class=\"{$r->{$map->chained}}\">{$r->name}</option>";
				}
				
				$dropdown .= "</select>";

				return $dropdown;
			}
			else {

				return form_dropdown($map->db, $map->values, set_value($map->db, $default), $id) . $sep;
			}
			
			
		case 'hidden':

			return form_hidden($map->db, isset($map->def) ? $map->def : $default) . $sep;
	
		case 'multiselect':
			return form_multiselect($map->db . '[]', $map->values, $default) . $sep;
			
		case 'file':
	
			$str = '<input type="file" style="width: auto; color: #888;" name="' . $map->db . '" />';
			
			$redirect = '.';
			
			if (!empty($default)) {
				
				$str .= "&nbsp;&nbsp;";

				if (strstr(strtolower($default), '.pdf')) {

					$str .= '<a class="file_actions" target="_blank" href="/assets/' . $default . '" >&nbsp;view&nbsp;</a>';
				}
				else {

					$str .= '<a class="file_actions single_image" href="/assets/' . $default . '" >&nbsp;view&nbsp;</a>';
				}

				if (!empty($map->deletable)) {
					$str .= "&nbsp;";
					$str .= '<a class="file_actions" data-ask="Are you sure you want to delete this file?" 
								href="javascript: delete_form(' . $c->form_model->record[$c->form_model->id->key] . ',\'' .
								$map->db . '\')">delete</a>';
				}
			}
			
			if (!empty($map->note)) {
				
				$str .= '&nbsp;<span class="note">' . $map->note. '</span>';
			}
			
			$str .= $sep;
			return $str;
		
		case 'radio':
			
			$radios = array();
			$css = 'class="chkbox"';

			foreach($map->values as $k => $v) {

				$val = set_value($map->db, $default);
				
				$radio_def = array(
					'id' => $map->db.$k,
					'name' => $map->db,
					'value'=> $k,
					'class'=> 'chkbox', 
					'checked' => $val == $k ? "checked" : ""
				);
				
				$radios[] = '<label for="' . $radio_def['id'] . '" class="chkbox">';
				$radios[] = form_radio($radio_def);	
				$radios[] = $v;
				$radios[] = "</label>";
			}
			
			return implode('', $radios) . $sep;
			
			
		case 'checkbox':

			$radios = array();
			$css = 'class="chkbox"';
			$radios[] = '<span class="checklist">';

			$fld_name = str_replace('[]', '', $map->db);

			if (!empty($_POST[$fld_name])) {
			
				$defs = $_POST[$fld_name];	
			}
			else {
				
				$defs = $map->defs;
			}
			
			foreach($map->values as $k => $v) {

				$radio_def = array(
					'id' => $map->db.$k,
					'name' => $map->db,
					'value'=> $k,
					'class'=> 'chkbox',
					'checked' => in_array($k, $defs) ? "checked" : ""
				);
				
				$radios[] = '<label for="' . $radio_def['id'] . '" class="chkbox">';
				$radios[] = form_checkbox($radio_def);	
				$radios[] = $v;
				$radios[] = "</label>";
			}
			
			$radios[] = "</span><br/>";
			return implode('', $radios) . $sep;
			
		case 'check':
			
			$radios = array();
			$css = 'class="chkbox"';
			$val = set_value($map->db, $default);
				
			$radio_def = array(
				'id' => $map->db,
				'name' => $map->db,
				'value'=> 1,
				'class'=> 'chkbox', 
				'checked' => $val == 1 ? "checked" : ""
			);
				
			$radios[] = '<label for="' . $radio_def['id'] . '" class="chkbox">';
			$radios[] = form_checkbox($radio_def);	
			$radios[] = "Yes</label>";

			return implode('', $radios) . $sep;
			
		case 'label':
			
			return $map->defs . $sep;
		
		
	}
}

function human_date($str) {
	
	return date('M j, Y', strtotime($str));
}

function featured_tags($tokens) {
	
	$c =& get_instance();
	
	$tbl = end($tokens);
	$tbl .= str_replace('.', '', microtime(TRUE)) . getmypid();
	

	$q = $c->db->query("
		CREATE TEMPORARY TABLE IF NOT EXISTS {$tbl} AS
		SELECT
			 distinct a.id,
			 a.name
		FROM
			`tags` a
				join project_tags b on (b.tag_id = a.id)
		order by
			a.name
	");
	
	return $tbl;
	
}

function expander($nav, $tbl, $col = 'name', $section_url, $type = 'side') {
	
	$c =& get_instance();

	$tokens = explode('.', $tbl);
	
	if (current($tokens) == 'callback') {
		
		$callback = end($tokens); 
		$tbl = $callback($tokens);
	}
	
	$tokens = explode(',', $tbl);
	$tokens = array_map('trim', $tokens);
	
	$tbl = $tokens[0];
	$prefix = isset($tokens[1]) ? $tokens[1] . ' ': '';
	$suffix = isset($tokens[2]) ? ' ' .$tokens[2] : '';

	$fields = $c->db->list_fields($tbl);

	$order_col = $col;
	
	if (in_array('seq', $fields)) {
		
		$order_col = 'seq';
	}
	
	$c->db->order_by($order_col, 'asc');
	$c->db->order_by($col, 'asc');
	
	if (isset($tokens[3])) {
		
		list($filter_col, $val) = explode('=', $tokens[3]);
		$c->db->where($filter_col, $val);		
	}
	$q = $c->db->get($tbl);
	
	foreach($q->result_object() as $r) {

		$r->$col = $prefix . $r->$col;
		$name = $type === 'home' ? "+ {$r->$col}" : $r->$col;
		$url = str_replace('[id]', $r->id, $nav->url);
		$leading = $type == 'home' ? '' : '/';
		
		echo '<li>';
		echo '<a href="' . $leading . $section_url . '/' . $url .'">&nbsp;' . ucwords($name). $suffix . '</a>';
		echo '</li>';
	}
}


function booleanify($val, $r = NULL, $def = NULL) {
	
	if (!empty($val)) {
		
		return 'Yes';
	}
	
	return '';
}

function cv($val, $r = NULL, $def = NULL) {

	if ($val) {
		return '<a class="gbut" href="/assets/' . htmlentities($val) . '"' . ' target="_blank">Download</a>'; 
	}

	return ''; 
}

function press($val, $r = NULL, $def = NULL) {

	if ($val) {
		return '<a class="gbut" href="/assets/' . htmlentities($val) . '"' . ' target="_blank">Download</a>'; 
	}

	return ''; 
}

function news_sort_item($val, $r = NULL, $def = NULL ){

	$ret = []; 

	if (isset($r->artist_name)) {

		$ret[] = "<strong>" . $r->artist_name . '</strong>'; 
	}

	if (isset($r->subtitle) && !empty($r->subtitle)) {

		$ret[] = $r->title . ' > ' . $r->subtitle; 
	}
	else {

		$ret[] = $r->title;
	}

	return implode('<br />', $ret);
}


function thumb($data) {

	return '<img src="/assets/' . $data . '" width="60" height="60" />';	
}

function set_as_primary($data, $r, $def) {
	
	if ($data) {

		$ret = 'Feature Photo&nbsp;&nbsp;'; 
		return $ret; 
	}
	else {
		
		$ret = '<a href="' . str_replace(array('[id]', '[image1]', '[filename]'), array(@$r->id, @$r->image1, @$r->filename), $def->x_url) . '" class="' . @$def->ecls . '">';
		$ret .= "Set as Featured Photo";
		$ret .= '</a>';
		
		return $ret; 
	}
}

function layout($data, $r, $def) {

	return Homepage::LAYOUT_CHOICES[$data];
}


function activate($data, $r, $def) {
	
	if ($data) {

		$ret = 'Active&nbsp;&nbsp;'; 
		return $ret; 
	}
	else {
		
		$ret = '<a href="' . str_replace(array('[id]', '[image1]', '[filename]'), array(@$r->id, @$r->image1, @$r->filename), $def->x_url) . '" class="' . @$def->ecls . '">';
		$ret .= "Activate";
		$ret .= '</a>';
		
		return $ret; 
	}
}

function viewer($data, $r, $def) {

	$label = 'View'; 
	$url = config_item('MAIN_SITE_URL');

	$fn = $def->x_url; 

	list($url, $label) = $fn($r, $url, $label);

	$ret = '<a href="' . $url . '" target="_blank">' . $label . '</a>';

	return $ret; 
}

function homepage($record, $url, $label) {

	if (!$record->is_primary) {

		$url .= '?preview=1&id=' . $record->id;
		$label = "Preview"; 
	}

	return [$url, $label];
}

function artist($record, $url, $label) {

	$url .= '/artists/profile/' . $record->slug; 

	if ( ! $record->is_published ) { 

		$url .= '?preview=1';
		$label = 'Preview';
	}

	return [ $url, $label ];
}


function exhibition($record, $url, $label) {

	$url .= '/exhibitions/profile/' . $record->slug; 

	if ( ! $record->is_published ) { 

		$url .= '?preview=1';
		$label = 'Preview';
	}

	return [ $url, $label ];
}