
<div class="inner_content">
	<h1><?=$section->name?><?=isset($category->name) ? " &gt; {$category->name}" : "" ?></h1>

	<?php if (!empty($errors)) { ?>
		<div id="errorbox" style="margin-top: 10px; margin-bottom: 3px;">
			Oops, please enter text in the field below.<br/>
		</div>
	<?php } ?>
	<?php if (!empty($success)) { ?>
		<div id="successbox" style="margin-bottom: 3px; margin-top: 10px;">
			Update successful.
		</div>
	<?php } ?>

	<form method="post" action="" id="form1" enctype="multipart/form-data" style="margin-top: 15px;">
		
		<p style="margin-left: 10px;">
			<textarea name="description" class="txtarea"><?=set_value('description', $description);?></textarea>
		</p>
		
	</form>

	<p class="factions" style="margin-left: 10px">
		<a href="javascript: " onclick="document.getElementById('form1').submit()">Save Changes</a>
	</p>
	
</div>

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
	width : 570,
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
