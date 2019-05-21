
	<main>

	<?php foreach($records as $i => $record) : ?>

		<?php if (($i % 3) == 0) : ?>
		<div class="news-3"></div>
		<?php endif; ?> 
		<?php if (($i % 2) == 0) : ?>
		<div class="news-2"></div>
		<?php endif; ?> 
		<div class="news-1"></div>

		<section>
		<?php if (!empty($record->artist_name)) : ?>
			<h2><?=$record->artist_name?></h2>
		<?php endif; ?> 
			<p><?=$record->title?></p>
		<?php if (!empty($record->subtitle)) : ?>
			<p><?=$record->subtitle?></p>
		<?php endif; ?> 
			<p><a href="<?=$record->link_url?>"><?=$record->link_name?> ↗ </a>
		</section>

	<?php endforeach; ?>

	</main>