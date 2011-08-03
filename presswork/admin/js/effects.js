(function($) {
	$('#backtotop').click(function(){
		$('html, body').animate({scrollTop:0}, 'slow');
	});		
	
	$("object, embed, .format-video iframe").each(function() {
		var origVideo = $(this);
		var aspectRatio = origVideo.attr("height") / origVideo.attr("width");
		var wrapWidth = origVideo.parents().find("p:last").width();
		if(origVideo.attr("width") > wrapWidth) {
			origVideo
				.attr("width", wrapWidth)
				.attr("height", (wrapWidth * aspectRatio));
		}
	});
	
	if($("#header_logo").length!=0) 
		$("#social-icons").appendTo("#header_logo").show();
	else if($("#blogname").length!=0) 
		$("#social-icons").appendTo("#blogname").show();

})(jQuery);