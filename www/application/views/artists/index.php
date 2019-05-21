<main>
	<ul class="list">
		<?php foreach($records as $record) : ?>
			<li>
				<h2><a href="/artists/profile/<?=$record->slug?>"><?=$record->first_name?> <?=$record->last_name?></a></h2>
				<a href="/artists/profile/<?=$record->slug?>"><?=_r($record->list_image, 'assets')?></a>	
			</li>		
		<?php endforeach; ?>
	</ul>
	<div class="feature-holder"></div>
</main>
