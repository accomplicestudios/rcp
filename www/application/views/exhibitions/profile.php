<main>
	<section>
		<h2 class="profile">
			<?php if ( ! empty($record->press) ) : ?>
				<a href="/assets/<?=$record->press?>" target="_blank">PRESS RELEASE ↗</a>
			<?php endif; ?>
		</h2>
		<div class="title">
			<h3><?=$record->first_name?> <?=$record->last_name?></h3>
			<h3><?=$record->title?></h3>
		</div>
		<div class="dates">
			<p><?=date('j F', strtotime($record->date_start))?> - <?=date('j F Y', strtotime($record->date_end))?></p>
			<p><?=$record->subtitle?></p>
		</div>
		<div class="spacer"></div>
		<?php 
			$up_cls = get_up_cls($record->gallery); 
			$gallery = array_chunk($record->gallery, 4);  
		?>
		<?php foreach($gallery as $items) : ?>
		<div class="gallery gallery-<?=$up_cls?>">
			<?php foreach ($items as $k => $image) : ?>
				<div><?=_r($image->choices, 'assets', $image->info, $k+1)?></div>
			<?php endforeach; ?> 
		</div>
		<?php endforeach; ?>

		<?php if ( ! empty ($record->installations) ) : ?>

		<div class="spacer"></div>
		<h2 class="installations">Installation</h2>
		<?php 
			$up_cls = get_up_cls($record->installations); 
			$gallery = array_chunk($record->installations, 4);  
		?>
		<?php foreach($gallery as $items) : ?>
		<div class="gallery gallery-<?=$up_cls?> gallery-installations">
			<?php foreach ($items as $k => $image) : ?>
				<div><?=_r($image->choices, 'assets', $image->info, $k+1)?></div>
			<?php endforeach; ?> 
		</div>
		<?php endforeach; ?>
		<?php endif; ?>

	</section>

	<section>
		<ul class="pager">
			<li>&nbsp;</li>
			<li><a href="/exhibitions">BACK TO ALL</a></li>
			<li>&nbsp;</li>
		</ul>
	</section>

</main>

<div class="overlay">
	<div class="item" data-current-seq=""></div>
	<div class="controls">
		<span class="previous">←</span>
		<span class="info"><span class="current"></span> <span>/</span> <span class="total_items"></span></span>
		<span class="next">→</span>
	</div>
	<div class="info"></div>
</div>