jQuery(document).ready(function() {

	// jQuery('#loading').hide('fast');
	//
	// jQuery('.ms-reset-data').click(function() {
	// 	event.preventDefault();
	//
	// 	my_data = {
	// 		action: 'membersuite_reset',
	// 		security: 'membersuite_ajax.nonce',
	// 		_ajax_nonce: membersuite_ajax.nonce
	// 	};

	// jQuery.ajax({
	// 	type: 'POST',
	// 	url: membersuite_ajax.ajaxurl,
	// 	data: my_data,
	// 	success: function(response) {
	// 		if ('success' == response.type) {
	// 			alert('success');
	// 			// $(".jsforwp-total-likes").html(0);
	// 		} else {
	// 			// console.log(response);
	// 			alert('Something went wrong!');
	// 		}
	// 	}
	//
	// });
	// });

	// 	jQuery('.membersuite_delete_row').on('click', function(e) {
	// 		var record_id = this.id;
	//
	// 		my_data = {
	// 			action: "delete_row",
	// 			record_id: record_id,
	// 			security: membersuite_ajax.nonce
	// 		}
	//
	// 		jQuery.ajax({
	// 			type: 'POST',
	// 			url: membersuite_ajax.ajaxurl,
	// 			data: my_data,
	// 			// beforeSend: function() {
	// 			// 	jQuery('#loading').show('slow')
	// 			// },
	// 			// complete: function() {
	// 			// 	jQuery('#loading').hide('fast')
	// 			// },
	//
	// 			success: function(response) {
	// 				if ('success' == response.type) {
	// 					jQuery('#alerts').append("<div class=\"alert alert-success\" role=\"alert\">This is a success alert—check it out!<button type = \"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
	// 					// pop row
	// 					var row = jQuery(this).parent().parent();
	// 					console.log(row);
	// 					row.remove();
	// 				} else {
	// 					jQuery('#alerts').append("<div class=\"alert alert-danger\" role=\"alert\">This is a danger alert—check it out! <button type = \"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>");
	// 					console.log(response);
	// 				}
	// 				// console.log(data);
	// 				// add success message
	//
	// 			},
	// 			error: function(data) {
	//
	// 			}
	// 		});
	// 	})
});

// jQuery(document).on('click', '.membersuite_delete_row', function() {
//
// });