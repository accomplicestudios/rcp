<?php 

class Cfg extends CI_Controller {
	
	public $vars = array(
		'works',
		'genres',
		'series',
		'about',
		'kollective'
	);
	
	public $path = '/Volumes/Beta/www/cms.kontent.com/vars/';
	
	function index() {
		
		$this->db->query('truncate table categories');
		
		foreach($this->vars as $k => $v) {
			
			$path = $this->path . $v . ".txt";
			if (file_exists($path)) {
				
				$lines = file($path);
				$section = $this->navs_model->section($v);
				
				foreach($lines as $i => $line) {
					
					$tokens = explode('|', $line);
					
					switch(count($tokens)) {
						
						case 1:
							$this->_insert_category($tokens[0], '', (substr($tokens[0],0,1) =='-' ? 'divider' : 'normal'), $section->id);
							break;
						
						case 4:							
							$this->_insert_category($tokens[0], $tokens[3], $tokens[1], $section->id, $tokens[2]);
							break;
					}
				}
			}
		}
		
		echo 'Done';
	}
	
	protected function _insert_category($name, $url, $type, $section_id, $expander = '') {
		
		$name = $this->db->escape_str($name);
		
		$type = empty($type) ? 'normal' : $type;
		$s = "
				select MAX(seq) as seq from categories where section_id = {$section_id}
		";
		$seq = $this->db->query($s)->row()->seq +1;
		
		$url = trim($url);
		
		$s = "
			insert into
				categories
			(
				name,
				url,
				section_id,
				type,
				expander,
				seq
			)
			values
			(
				'{$name}',
				'{$url}',
				'{$section_id}',
				'{$type}',
				'{$expander}',
				'{$seq}'
			)
		";
		
		$this->db->query($s) or die($s);
	}
}