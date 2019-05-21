<div class="inner_content">
	<h1><?=$section->name?><?=isset($category->name) ? " &gt; {$category->name}" : "" ?></h1>

	<?php /*draw_action_navs($pagenavs); */?>
	
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
		
		<?php if (empty($sent)) { ?>
				<?=show_success(!empty($success) || $this->session->flashdata('update'), 'Update successful.', 560);?>
		<?php } ?>
			
		<?=show_success(!empty($sent), 'Email sent.', 560);?>

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
				
					if (!empty($map->section)) {
						
						echo "<p><label class=\"section_title\">{$map->section}</label></p>";
					}
				?>
				<p id="<?=(isset($map->p_id) ? $map->p_id : '')?>">
					<label><?=$label?></label>
					<?=draw_input($map);?>
					
					<?php if (isset($map->url)) {
							$url_id = isset($map->url_id) ? $map->url_id : "";
						?>
						
						&nbsp;<a href="<?=$map->url?>" id="<?=$url_id?>" class="gbut" style="float: none;"><?=$map->url_text?></a>
					<?php								
						}
					?>
				</p>	
				<?php } ?>
		<?php	} ?>
		<input type="hidden" name="id" id="delete_form_id" value="" />
		<input type="hidden" name="key" id="delete_form_key" value="" />
		<input type="hidden" name="act" id="delete_form_act" value="">

	</form>

	<div class="separ_final"></div>

	<p class="factions" style="width: 100%">
		<span style="float: left; ">
		<a href="javascript: " onclick="document.getElementById('form1').submit()"><?=!empty($submit)? $submit : "Save Changes"?></a>
		<?php if (isset($redirect_url)) { ?>
		<a href="<?=$redirect_url?>">Back to List</a>
		<?php } ?>
		</span>
		
		<?php if (!empty($factions)) {
			
				echo '<span style="float:right; margin-right: 10px; ">';
				foreach($factions as $url => $name) {
						
					echo "<a href=\"{$name[0]}\" target=\"" . @$name[2] . "\">{$name[1]}</a>";
				}
				
				echo '</span>';
		}?>


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
