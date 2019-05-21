
	<?php if (!empty($has_footer)) : ?>

	<footer>
		<div class="contact">
			<ul>
			<?php if ($contact) : ?>
				<li><a href="<?=$contact->googlemaps?>" target="_blank"><?=$contact->street?></a></li>
				<li><a href="<?=$contact->googlemaps?>" target="_blank"><?=$contact->city?></a></li>
				<li><a href="mailto:<?=$contact->email?>"><?=$contact->email?></a></li>
				<li><?=$contact->phone?></li>
			<?php endif; ?> 
			</ul>
		</div>
		<div class="social">
		<?php if ($sociables) : ?>
			<ul>
			<?php 
				foreach(['instagram', 'facebook', 'subscribe'] as $v) :
					
					if (trim($sociables->$v)) :
			?>
						<li><a href="<?=$sociables->$v?>"><?=ucwords($v)?></a></li>
			<?php 
					endif;
				endforeach;
			?>
			</ul>			
		<?php endif; ?>

		</div>
	</footer>
	
	<?php endif; ?>
	
	<!-- Baby, come back ;) -->

	<?php 
		//<div class="window-width-marker">TEST</div>
	?>
</body>
</html>