$(document).ready(function() {
	$("#author-select").change(function() {
		$("#quote").empty();
		$("#error-message").empty().hide();
		$("#author-spinner").addClass("loading");

		var author = $(this).val();
		if (author) {
			$.getJSON(api_endpoint + "/shout.php", { author: author, limit: 1}, function(res) {
				$("#author-spinner").removeClass("loading");

				if (res && res.quotes) {
					$("#quote").html(res.quotes[0]);
				}
				else {
					var msg = res.error || "API error!";
					$("#error-message").html(msg).show();
				}
			})
		}
	});
});