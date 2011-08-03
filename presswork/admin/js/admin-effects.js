(function($) {
	$(".active").click(function() {
		if($(this).hasClass("deactivate")) {
			var value = "off";
		} else {
			var value = "on";
		}
		var theURL = presswork.front_url;
		var el = $(this);
		var loader = $("#active-button img");
		var message = $("#message");
		loader.show();
		var data = {
			action: 'turn_on_toolbox',
			option: value
		};
		$.post(ajaxurl, data,
		function(response){
			if(value=="on") {
				window.location = theURL;
			} else {
				el.toggleClass("deactivate");
				message.show();
				loader.hide();
				setTimeout(function() { message.slideUp(); }, 3000);
			}
		});
	});
})(jQuery)