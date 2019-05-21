  <section >
		<h2><?=$current_title?></h2>
		<div class="title">
			<h3><a href="/exhibitions/profile/<?=$record->slug?>"><?=$record->first_name?> <?=$record->last_name?></a></h3>
			<h3><a href="/exhibitions/profile/<?=$record->slug?>"><?=$record->title?></a></h3>
		</div>
		<div class="dates">
			<p><?=date('j F', strtotime($record->date_start))?> - <?=date('j F Y', strtotime($record->date_end))?></p>
			<p><?=$record->subtitle?></p>
		</div>
		<div class="spacer"></div>
		<div class="gallery static">
			<div>
      	<a href="/exhibitions/profile/<?=$record->slug?>"><?=_r($record->list_image, 'assets')?></a>
			</div>
		</div>
	</section>