;(function($) {
	// Default
	$('#book-review .ratyli').ratyli({
		max     : 5,
		rate    : 2,
	});
	// Book rating AJAX handler
	$("#book-review .ratyli").on("click", function (e) {
		// Data objct to send PHP via AJAX request
		let userData = {
			_ajax_nonce: BookRatings.rating_nonce,
			action     : 'book_review_rating',
			post_id    : $(this).attr("data-post-id"),
			rating     : $(this).attr("data-rate"),
			rating_id  : $(this).attr("data-rating-id"),
		}
		// Ajax request handler
		$.post(BookRatings.ajaxurl, userData, function (response) {
			if(true === response.success) {
				$("#book-review .ratyli").attr("data-rating-id", response.data.rating_id);
				$(".rating-status").removeClass("status-error").addClass("status-success");
			} else {
				$(".rating-status").removeClass("status-success").addClass("status-error");
			}
			$(".rating-status").html(response.data.message);
		})
		.fail(function () {
			alert(BookRatings.error);
		});
	});

})(jQuery);