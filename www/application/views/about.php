
	<main>

		<section class="splash">
			<h2>&nbsp;</h2>
			<?=($tagline ? $tagline->description : '')?>
		</section>

		<section class="visit">
			<h2>Visit</h2>
			<?php if ($contact) : ?>
			<p><a href="<?=$contact->googlemaps?>" target="_blank"><?=$contact->street?> ↗<br /><?=$contact->city?></a></p>
			<p><?=$contact->phone?></p>
			<?php endif; ?>
		</section>

		<section class="hours">
			<h2>Hours</h2>
			<?=($hours ? show_about_text($hours->description) : '')?>
		</section>

		<section class="transpo">
			<h2>Public Transportation</h2>
			<?=($public_transportation ? $public_transportation->description : '')?> 
		</section>

		<section class="parking">
			<h2>Parking</h2>
			<?=($parking ? show_about_text($parking->description) : '');?>
		</section>

		<?php if ($disclaimer) : ?>
		<div class="antihero">
			<img src="<?=_cdn("/assets/" . $disclaimer->photo)?>" alt="" />
			<p><?=($disclaimer->description)?></p>
		</div>
		<?php endif; ?>

	</main>