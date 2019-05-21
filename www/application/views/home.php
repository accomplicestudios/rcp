	<main>
		<h2>
			<?php if ( ! empty($homepage->link) ) : ?>
			<a href="<?=$homepage->link?>">
			<?php endif; ?>

				<?=$homepage->title?>
				<?php if ( ! empty($homepage->subtitle) ) : ?>
					<br /><?=$homepage->subtitle?>
				<?php endif; ?>
				
			<?php if ( ! empty($homepage->link) ) : ?>
			</a>
			<?php endif; ?>
		</h2>

		<?php if ( !empty($homepage->line1) || !empty($homepage->line2) ) : ?>

		<h3>
			<?php if ( ! empty($homepage->line1) ) : ?>
			<?=$homepage->line1?>
			<?php endif; ?> 
			<?php if ( ! empty($homepage->line2) ) : ?>
			<br /><?=$homepage->line2?>
			<?php endif; ?> 
		</h3>
		<?php endif; ?>

	</main>