
function setup_navs_order() {

	var elem = $('.navs li.current'); 

	// for smartphone resolutions
	if ($(window).width() < 768) {

		$(elem).parent().prepend($(elem)); 
	}
	else {

		$(elem).parent().append($(elem)); 
	}
}

function setup_navs_events() {

	$('.navs ul').hover( 
		function(){ // in 
			$(this).find('li').addClass('activate');
			$(this).find('li.home').removeClass('activate');
		}, 
		function(){ // out 
			setTimeout(
				function() 
				{
					$('.navs ul').find('li').removeClass('activate');
					$('.navs ul').find('li.current').addClass('activate');
				}, 2000);
		}
	); 
}

function setup_artist_list_events() {

	$('.artists .list h2').hover( 
		function(){ // in 

			if ($(window).width() >= 768) {
				$('.artists .list h2').removeClass('focus');
				$(this).addClass('focus');
				$('.feature-holder').html($(this).next('a').clone()).slideDown(); 
			}
		}, 
		function(){ // out 
		}
	); 
}

function setup_artist_feature() {

	$('.artists .list li:first-child h2').trigger('mouseenter');
}

function set_focus(idx) {

	var focus = $(".gallery div img[data-seq-no='" + idx + "']"); 

	$('.overlay .item').html($(focus).clone());
	$('.overlay .controls .info .current').text($(focus).data('seq-no')); 
	$('.overlay .controls .info .total_items').text($('.gallery div').length);
	$('.overlay > .info').html($(focus).data('info'));
	$('.overlay .item').attr('data-current-seq', $(focus).data('seq-no'));
}

function setup_gallery() {

	$('.gallery:not(.static) div img').on('click', function() {

			$('body').css('overflow', 'hidden');
			set_focus(parseInt($(this).data('seq-no')));
			$('.overlay').show();
			$('.overlay').attr('data-activated', '1');
	});

	$('.overlay .item').on('click', function() {
		$('body').css('overflow', 'visible');
		$('.overlay').hide();
	});

	$('.overlay .controls .previous').on('click',  function() {

		var current_seq = parseInt($('.overlay .item').attr('data-current-seq'));
		var idx_focus = current_seq == 1 ? parseInt($('.gallery div').length) : current_seq - 1; 

		set_focus(idx_focus);
		return false; 
	});

	$('.overlay .controls .next').on('click', function() {

		var current_seq = parseInt($('.overlay .item').attr('data-current-seq'));
		var idx_focus = current_seq == parseInt($('.gallery div').length) ? 1 : current_seq + 1; 
		set_focus(idx_focus);
		return false;
	});
}

function setup_favicons() {

	var favicon_images = [
		'favicon-r.ico',
		'favicon-c.ico',
		'favicon-p.ico'
	], 

	image_counter = 0; // To keep track of the current image

	setInterval(function() {
		$("link[rel='icon']").remove();
		$("head").append('<link rel="icon" type="image/x-icon" href="/' + favicon_images[image_counter] + '" >');

		if(image_counter == favicon_images.length -1)
			image_counter = 0;
		else
			image_counter++;
	}, 1000);
}

$(document).ready(function() {

	setup_navs_order();
	setup_navs_events(); 
	setup_artist_list_events(); 
	setup_artist_feature(); 
	setup_gallery();

	$('.window-width-marker').html($(window).width()); 

	$(window).on('resize', function() {

		setup_navs_order();
		setup_artist_feature(); 
		$('.window-width-marker').html($(window).width()); 
	});

	$('.header-anchor').click(function(e){

		if (e.target === this) {

			window.location = $(this).data('url');
			return false; 
		}
	});

	$(document).keydown(function(e) {

		if ($('.overlay').css('display') == 'block') {
			switch(e.which) {
				case 37: // left
				case 38: // up
					$('.overlay .previous').trigger('click');

				break;
		
				case 39: // right
				case 40: // down
					$('.overlay .next').trigger('click');
				break;

				case 27: // esc 
					$('.overlay .item').trigger('click');
				break;

				default: return; // exit this handler for other keys
			}

			e.preventDefault(); // prevent the default action (scroll / move caret)
		}
	});
});
