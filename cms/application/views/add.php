
<div class="inner_content">
	<h1><?=$section->name?><?=isset($category->name) ? " &gt; {$category->name}" : "" ?></h1>
	<?php /*
	<?=draw_action_navs($pagenavs)?>
		*/
	?>
	<?php if (!empty($tabs)) {

			draw_tabs($tabs, $id, $action_type);
		}
	?>
	
	<form method="post" action="" id="form1" enctype="multipart/form-data" style="padding-bottom: 10px">
		
		<?php if (!empty($errors)) { ?>
		
			<div id="errorbox" style="width: 570px">
				Sorry, the following errors occurred while trying to process this request:<br/>
				<?=$errors?>
			</div>
		
		<?php } ?>

		<?=show_success(!empty($success), 'Message sent.', 560);?>

		<?php foreach($maps as $map) {

				$map = (object)$map;	

				$label = !empty($map->label) ? $map->label : '';
				
				if (!empty($label)) {
					
					if (!isset($map->rules)) {
						
						$label .= '*';
					}
					else if (strstr($map->rules, 'required')) {

						$label .= '*';
					}
				}

				
				if ($map->type === 'hidden') {

					echo draw_input($map);
				}
				else {
					
				?>
					<p>
						<label><?=$label?></label>
						<?=draw_input($map);?>
					</p>
		<?php	}		
			} ?>
	</form>
	
	<div class="separ_final"></div>

	<p class="factions">
		<a href="javascript: " onclick="document.getElementById('form1').submit()">Save</a>
		<a href="<?=$redirect_url?>">Cancel</a>
	</p>
	
</div>

<?php
	$extra_buttons = "";
	$controller = $this->router->fetch_class();

	if (in_array($controller, array('blog'))) {
	
		$extra_buttons = ",separator, image";	
	}
?>
<script type="text/javascript" src="/css/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,separator,link,unlink,separator,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "",
    theme_advanced_blockformats : "p,h1,h2",
	width :510,
	relative_urls: false,
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
