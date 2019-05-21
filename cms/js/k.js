jQuery(document).ready(function() {
	
	jQuery('.glist-sort').sortable();
	jQuery('.glist-sort').disableSelection();
	
	jQuery('.sortbtn').click(function() {
		
		jQuery('#items').val(jQuery('.glist-sort').sortable('serialize'));
		jQuery('.sortform').submit();
		
		return false;
	});

	/* This is basic - uses default settings */
	
	jQuery("a.single_image").fancybox();

	jQuery("#child_chain1").chained("#parent_category");
	
	jQuery("#parent_category").change(function() {
		
		var val = jQuery('#parent_category option:selected').val();
		jQuery("#child_chain1_url").attr({'href': '/projects/clients/' + val + '/list/add'});
	});

	var val = jQuery('#parent_category option:selected').val();
	jQuery("#child_chain1_url").attr({'href': '/projects/clients/' + val + '/list/add'});
	
	jQuery('select#parent_category').change(function() {
		
		var selected_value = jQuery(this).attr('value');
		
		if (selected_value == '23') { // text
		
			jQuery('#image1').hide();	
		}
		else if (selected_value == '24') { // photo
			
			jQuery('#image1').show();
			jQuery('#front_text').hide();
		}
		else if (selected_value == '25') { // calendar
			
			jQuery('#image1').hide();
			jQuery('#front_text').show();
		}
	});

	if (jQuery('select#parent_category')) {
		
		var selected_value = jQuery('select#parent_category').attr('value');
		
		if (selected_value == '23') { // text
		
			jQuery('#image1').hide();	
		}
		else if (selected_value == '24') { // photo
			
			jQuery('#image1').show();
			jQuery('#front_text').hide();
		}
		else if (selected_value == '25') { // calendar
			
			jQuery('#image1').hide();
			jQuery('#front_text').show();
		}
	}
	
	jQuery('a[href*="delete"]').click(function(){

		var ask = $(this).attr('data-ask') || 'Are you sure you want to delete this record?'; 
		var record = $(this).attr('data-record') || '';
		
		if (record != '') {

			ask = ask + '\n\n' + record; 
		}
	
		if (confirm(ask)) {
			return true; 
        }
		else {
			return false;
		}
	});

});


function delete_form(id, key) {
	
	document.getElementById('delete_form_id').value = id;
	document.getElementById('delete_form_key').value = key;
	document.getElementById('delete_form_act').value = 'deletefile';
	document.getElementById('form1').submit();
}

