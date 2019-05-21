
<div class="inner_content">
	<h1><?=$section->name?><?=isset($category->name) ? " &gt; {$category->name}" : "" ?></h1>
	
	<?php

		if (!empty($pagenavs)) {
			
			draw_page_navs($pagenavs, 'left', empty($pagenavs_right));
		}

		if (!empty($pagenavs_right)) {
			
			draw_page_navs($pagenavs_right,'right', FALSE);
		}

	
		if (!empty($tabs)) {
		
			draw_tabs($tabs, $id, $action_type);
		}
	
		if (!empty($tabnavs)) {
			
			draw_page_navs($tabnavs);
		}
	?>

	<p>&nbsp;</p>
	<?=show_success($this->session->flashdata('deleted'), 'Entry deleted.', 700);?>
	<?=show_errorbox($this->session->flashdata('deleted-error'), $this->session->flashdata('deleted-error'), 700);?>
	<?php 
	
	if (is_array($listQ)) {

		$lists = $listQ;
		
		foreach($lists as $k => $v) {

			$listQ = $v->q;
			$listDefs = $v->defs;
			
			if ($listQ->num_rows()) { ?>
			
			<ul class="glist">
				<li class="glist-header">
	
				<?php foreach($listDefs as $def) { ?>
						<span class="<?=$def->cls?>" style="width: <?=$def->width?>"><?=!empty($def->label) ? $def->label : ''?></span>
				<?php } ?>
				</li>
				
				<?php foreach($listQ->result_object() as $r) { 
				?>
				
				<li>
						<?php foreach($listDefs as $def) {
							
								$func = !empty($def->formatter) ? $def->formatter : 'trim';
								$record = ''; 
								if (isset($def->record_map)) {

									$record = $r->{$def->record_map}; 		
								}							
						?>
								<span class="<?=$def->cls?>" style="width: <?=$def->width?>">
									<?=!empty($def->url) ? '<a href="' . str_replace(array('[id]','[filename]'), array(@$r->$listID, @$r->filename), $def->url) . '" data-record="' . htmlspecialchars($record)  .'">' : ""?>
										<?=!empty($def->title) ? $def->title : $func($r->{$def->map})?>					
									<?=!empty($def->url) ? '</a>' : ""?>
								</span>
						<?php } ?>
				</li>
				
				<?php } ?>
			</ul>
	<?php 
			}
		}
	}
	else {
		
		if ($listQ->num_rows()) { ?>
		
		<ul class="glist">
			<li class="glist-header">

			<?php foreach($listDefs as $def) {  
					
					if (isset($def->sort)) {
						$active_sort = $current_sort == $def->label ? 'style="color: red; text-decoration: underline"': "";
						?>
 						<span class="<?=$def->cls?>" style="width: <?=$def->width?>"><a <?=$active_sort?> href="<?=$sort_url?>/<?=$def->label?>"><?=!empty($def->label) ? $def->label : ''?></a></span>
<?php 				}
					else { ?>

						<span class="<?=$def->cls?>" style="width: <?=$def->width?>"><?=!empty($def->label) ? $def->label : ''?></span>						
<?php				} ?>
					
			<?php } ?>
			</li>
			
			<?php foreach($listQ->result_object() as $r) { 


				
				?>
			
			<li>
					<?php foreach($listDefs as $def) {

						$record = ''; 

						if (isset($def->record_map)) {

							$record = $r->{$def->record_map}; 		
						}	

						$func = isset($def->formatter) && !empty($def->formatter) ? $def->formatter : 'trim';							
					?>
							<span class="<?=$def->cls?>" style="width: <?=$def->width?>">
							<?=!empty($def->url) ? '<a href="' . str_replace(array('[id]','[filename]'), array(@$r->$listID, @$r->filename), $def->url) . '" data-record="' . htmlspecialchars($record)  .'">' : ""?>
									<?=!empty($def->title) ? $def->title : (isset($def->formatter) ? $func($r->{$def->map}, $r, $def) : $func($r->{$def->map}))?>					
								<?=!empty($def->url) ? '</a>' : ""?>
							</span>
					<?php } ?>
			</li>
			
			<?php } ?>
		</ul>	
	<?php } ?>

	<?php } ?>
	<?php if (!empty($contextnavs)) { ?>


	<p class="factions">
		<?php
			$navs_array = array();
			
			foreach($contextnavs as $pagenav) {
				
				$navs_array[] = "<a href=\"{$pagenav[0]}\">{$pagenav[1]}</a>";
			}
			echo implode('', $navs_array);
		?>
	</p>
	<?php } ?>
	
</div>