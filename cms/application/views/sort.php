
<div class="inner_content">
	<h1><?=$section->name?><?=isset($category->name) ? " &gt; {$category->name}" : "" ?></h1>
		
	<p><br/>&nbsp;&nbsp;&nbsp;&nbsp;Drag-n-drop items below to change order of appearance.</p>
	<br/>
	<?=show_success(!empty($sorted), 'Update successful.', 700);?>

	<?php if ($listQ->num_rows()) { ?>

		<ul class="glist-sort <?=$sortable_cls?>">
			
			<?php foreach($listQ->result_object() as $r) { ?>
			
			<li id="item_<?=$r->id?>">
					<?php foreach($listDefs as $def) {
							$func = !empty($def->formatter) ? $def->formatter : 'trim';							
					?>
						<span class="<?=$def->cls?>" style="width: <?=$def->width?>">
							<?=!empty($def->url) ? '<a href="' . str_replace(array('[id]', '[image1]', '[filename]'), array(@$r->$listID, @$r->image1, @$r->filename), $def->url) . '" class="' . @$def->ecls . '">' : ""?>
								<?=!empty($def->title) ? $def->title : (isset($def->formatter) ? $func($r->{$def->map}, $r, $def) : $func($r->{$def->map}))?>					
							<?=!empty($def->url) ? '</a>' : ""?>
						</span>

					<?php } ?>
			</li>
			
			<?php } ?>
		</ul>	
	<?php } ?>

	<br style="clear: both" />
	
	<div class="separ_final" style="margin-top: 30px"></div>

	<p class="factions">
		<a href="javascript: " class="sortbtn">Save Changes</a>
		<a href="<?=$redirect_url?>">Back to List</a>
	</p>			
	
	<form class="sortform" method="post" action="">
		<input type="hidden" name="items" id="items" />
	</form>

	
</div>
