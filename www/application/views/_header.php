<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Rebecca Camacho Presents</title>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<script type="text/javascript" src="<?=_cdn("/js/jquery.js")?>"></script>
	<script type="text/javascript" src="<?=_cache_buster("/js/r.js")?>" ></script>
	<script type="text/javascript" src="<?=_cdn("/js/pace.js")?>"></script>
	<style>.pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#fe63c5;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:3px}body:after,body:before,body>:not(.pace){-webkit-transition:opacity .4s ease-in-out;-moz-transition:opacity .4s ease-in-out;-o-transition:opacity .4s ease-in-out;-ms-transition:opacity .4s ease-in-out;transition:opacity .4s ease-in-out}body:not(.pace-done):after,body:not(.pace-done):before,body:not(.pace-done)>:not(.pace){opacity:0}</style>
	<script type="text/javascript">
		Pace.on('done', function(e) {
			setup_favicons();
		});
	</script>
	<meta name="keywords" content="rebecca camacho presents" />
	<meta name="description" content="" />

	<link rel="icon" href="/favicon-r.ico" />

	<!-- Keep scale -->	
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<!-- All men are equal -->
	<link rel="stylesheet" type="text/css" href="<?=_cdn("/styles/reset.css")?>" media="all" />

	<!-- Font -->
	<link rel="stylesheet" type="text/css" href="<?=_cdn("/styles/fonts.css")?>" media="all" />

	<!-- Main styles -->
	<link rel="stylesheet" type="text/css" href="<?=_cache_buster("/styles/r.css")?>" media="all" />
	<link rel="stylesheet" type="text/css" href="<?=_cache_buster("/styles/debug.css")?>" media="all" />

	<!-- Media Queries -->
	<link rel="stylesheet" href="<?=_cache_buster("/styles/mq/768.css")?>" media="screen and (min-width: 767px)" />
	<link rel="stylesheet" href="<?=_cache_buster("/styles/mq/1024.css")?>" media="screen and (min-width: 1024px)"  />
	<link rel="stylesheet" href="<?=_cache_buster("/styles/mq/1440.css")?>" media="screen and (min-width: 1440px)"  />

	<?php if ( ! empty($bg_css) ) : ?>
	<style>header {<?=$bg_css?>}</style>
	<?php endif; ?>

</head>

<body class="<?=$page_css?>">
	<header class="<?=isset($homepage, $homepage->layout) ? $homepage->layout : ''?> <?=isset($homepage) && !empty($homepage->link) ? 'header-anchor' : ''?>" data-url="<?=isset($homepage, $homepage->link) ? $homepage->link : ''?>">
		<div>
			<div class="logo"><a href="/"><img src="<?=_cdn("/images/{$logo}")?>" alt="logo" /></a></div>
			<div class="navs <?=(isset($homepage, $homepage->menu_color) ? 'navs-' . $homepage->menu_color  :'')?>">
				<ul>
					<li class="home <?=($current=='home' ? 'current activate': '')?>"><a href="/">Menu</a></li>
					<li class="artists <?=($current=='artists' ? 'current activate': '')?>"><a href="/artists">Artists</a></li>
					<li class="exhibitions <?=($current=='exhibitions' ? 'current activate': '')?>" ><a href="/exhibitions">Exhibitions</a></li>
					<li class="about <?=($current=='about' ? 'current activate': '')?>"><a href="/about">About</a></li>
					<li class="news <?=($current=='news' ? 'current activate': '')?>"><a href="/news">News</a></li>
				</ul>
			</div>
		</div>
	</header>

	