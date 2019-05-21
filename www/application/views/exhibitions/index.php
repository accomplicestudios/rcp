<main>

	<?php 
		$current_title = 'Current'; 
		$is_upcoming_shifted = FALSE; 
		$record = $current_item; 

		if ( empty($current_item) && !empty($upcoming_items) ) {

			$record = array_shift($upcoming_items);
			$current_title = 'Upcoming';
			$is_upcoming_shifted = TRUE;   
		}

		!empty($current) && include('current.php');
	?>

	<?php if ( ! empty($upcoming_items) ) :  ?>

		<section>
			<?php if ( ! $is_upcoming_shifted ) : ?>
				<h2>Upcoming</h2>
			<?php endif; ?> 

			<?php
				$exhibitions = $upcoming_items;
				include('section-list.php');
			?>

		</section>
	<?php endif; ?>

	<?php if ( ! empty($past_items) ) :  ?>

		<section>
			<h2>Past</h2>

			<?php
				$exhibitions = $past_items;
				include('section-list.php');
			?>

		</section>
	<?php endif; ?>


</main>

