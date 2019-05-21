<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=$this->config->item('SITE_TITLE')?></title>
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="all" />

	<link rel="stylesheet" href="/css/main.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/js/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />	
	<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="/js/jquery.chained.mini.js"></script>
	<script type="text/javascript" src="/js/fancybox/jquery.fancybox-1.3.1.pack.js"></script>
	<script type="text/javascript" src="/js/k.js"></script>
</head>
<body>
<div id="container">

	<div id="sidebar">

		<div class="header">
			<div style="padding-top: 34px"><img src="/images/RCP_Logo_Wht.svg"  height="60px" /></div>
		</div>
		
		<ul id="sidenavs">
			<?php foreach($navs->result_object() as $nav) {?>
				<?php $active_cls = $nav->url == $section_url ? 'class="nactiv"' : ""?>
		
				<li <?=!empty($active_cls) ? 'style=" background: #0d0d0d"' : ''?> ><a <?=$active_cls?> href="/<?=$nav->url?>"><?=$nav->name?></a>
			<?php 
				if ($nav->url == $section_url) {
					
					$categories_head = $this->navs_model->cats($nav->id);
					
					if ($categories_head->num_rows()) {
						
						echo '<ul>';
						$found = FALSE;
						
						foreach($categories_head->result_object() as $snav) {
							$activ_class = '';
							
							//if (!$found) {
							//
							//	$activ_class = $snav->url == $category_url ? ' class="subactiv"' : '';
							//
							//	if (empty($activ_class)) {
							//
							//		if (!empty($snav->url)) {
							//
							//			if (strstr($category_url, $snav->url)) {
							//				
							//				$activ_class = ' class="subactiv"';
							//			}
							//		}
							//
							//		//$category_orig = explode('/', $category_url);
							//		//if (is_numeric(end($category_orig))) {
							//		//	
							//		//	array_pop($category_orig);
							//		//}
							//		//else {
							//		//	
							//		//	echo $snav->url;
							//		//}
							//		//$category_orig = '/' . implode('/', $category_orig) . '/';
							//	}
							//	else {
							//		
							//		//echo $snav->url . ':' . $category_url;
							//	}
							//	
							//	$found = !empty($activ_class);
							//}
							
							if ($snav->type === 'divider') {
								
								echo '<div class="separ_menus"></div>';
							}
							else if ($snav->type === 'normal') {

								echo '<li>';
								echo '<a href="/' . $section_url . '/' . $snav->url . '" ' . $activ_class . '>' . $snav->name . '</a>';
								echo '</li>';
							}
							else if ($snav->type === 'sub') {
								
								echo '<li>';
								echo '<span class="subheader">' . $snav->name . '</span>';
								echo '</li>';
								
								$snav->expander && expander($snav, $snav->expander, 'name', $section_url);
							}
							else if ($snav->type === 'sub-static') {

								echo '<li>';
								echo '<a href="/' . $section_url . '/' . $snav->url . '" ' . $activ_class . '>&nbsp;' . $snav->name . '</a>';
								echo '</li>';
							}
							else if ($snav->type === 'blank') {
								
								if (!empty($snav->expander)) {
									
									expander($snav, $snav->expander, 'name', $section_url);
								}
							}

						}
						
						echo '</ul>';
					}
				}
			?>
				</li>
	
			<?php } ?>
		</ul>
	</div>
	
	
	<div id="content">
		
		<div class="header">
			<ul id="navs">
				<a class="controlpanel" href="/home">Control Panel</a>
				<a class="viewsite" href="<?=$this->config->item('MAIN_SITE_URL')?>" target="_blank">View Site</a>
				<a class="logout" href="/logout">Logout</a>
			</ul>
		</div>

		<div id="inner">