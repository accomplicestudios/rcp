<main>
	<section>
		<h2><?=$record->first_name?> <?=$record->last_name?></h2>
		<ul class="jumps">
			<?php if (!empty(trim($record->cv))) : ?>
			<li><a href="/assets/<?=$record->cv?>" target="_blank">CV ↗</a></li>
			<?php endif; ?>
			<?php if (!empty(trim($record->press))) : ?>
			<li><a href="/assets/<?=$record->press?>" target="_blank">PRESS ↗</a></li>
			<?php endif; ?>
			<?php if (!empty($record->exhibitions)) : ?>
			<li><a href="#exhibitions">EXHIBITIONS</a></li>
			<?php endif; ?>
		</ul>
		<div class="rule"></div>
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
	</section>

	<?php if ( ! empty($record->exhibitions) ) : $exhibitions = $record->exhibitions; ?>
	<section class="xlist-section">
		<a id="exhibitions"></a>
		<h2>Exhibitions</h2>
		<?php include(APPPATH . '/views/exhibitions/section-list.php'); ?>
	</section>
	<?php endif; ?> 

	<section>
		<ul class="pager">
			<li><a href="<?=$record->previous->slug?>">PREVIOUS<br/><?=_r($record->previous->list_image, 'assets')?></a></li>
			<li><a href="/artists">BACK<span> TO LIST</span></a></li>
			<li><a href="<?=$record->next->slug?>">NEXT<br/><?=_r($record->next->list_image, 'assets')?></a></li>
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
