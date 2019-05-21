    <div class="xlist">
		<?php foreach($exhibitions as $exhibition) : ?>
			<div>
        <?php 
          $url = $exhibition->date_start <= date('Y-m-d') ? "/exhibitions/profile/{$exhibition->slug}" : 'javascript:void()'; 
        ?>
				<a href="<?=$url?>">
            <img src="/assets/<?=current($exhibition->list_image)?>" />
            <span class="heading">
              <?php if ( isset($exhibition_show_artist_name) && $exhibition_show_artist_name) : ?> 
              <h4><?=$exhibition->first_name?> <?=$exhibition->last_name?></h4>
              <?php endif; ?>
              <p><?=$exhibition->title?><p>
              <p><?=date('j F', strtotime($exhibition->date_start))?> - <?=date('j F Y', strtotime($exhibition->date_end))?></p>
            </span>
        </a>
			</div>
		<?php endforeach; ?>
    </div>
