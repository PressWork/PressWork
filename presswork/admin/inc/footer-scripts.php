<?php
/**
 * These are the jQuery scripts needed to run PressWork
 * so don't mess with this file
 *
 * @since PressWork 1.0
 */
function pw_footer_scripts() {
	?>	
<script type="text/javascript" src="<?php echo admin_url("js/farbtastic.js"); ?>"></script>
<script type="text/javascript">
/* <![CDATA[ */
(function($) {
<?php global $pw_welcome; if(!empty($_GET['action']) && $_GET['action']=="pw-activate" && empty($pw_welcome)) { ?>
	$("#close-welcome").click(function() {
		var nonce = $("input#presswork_nonce").val();
		var data = {
			nonce: nonce,
			action: 'remove_welcome_screen'
		};
		$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
		function(response){
			$("#pw_welcome_screen, #pw_fadeback").fadeOut("slow", 
				function() { 
					window.location = "<?php echo home_url("/"); ?>";

				});
		});
	});
	$(document).ready(function() {
		var pos = $("#wp-admin-bar-presswork-options").position();
		$(".adminbar-arrow").css({ left: pos.left-30 }).show();
	});
<?php } ?>
	$("#savetheme").click(function() {
		$("#themeform").trigger("submit");
		$(this).removeClass("remember");
		return false;
	});
	$("#themeform").submit(function() {
		var nonce = $("input#presswork_nonce").val();
		var loader = $("#ajaxloader");
		var message = $("#save_message");
		message.hide();
		loader.show();
		var data = {
			action: 'save_theme_options',
			nonce: nonce,
			option: $(this).serialize(),
		};
		$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
		function(response){
			loader.hide();
			message.fadeIn();
			setTimeout(function() { message.fadeOut(); }, 5000);
		});
		return false;
	});	
	$("#colorselect").change(function() {
		colorselect();
	});
	$("#layoutselect").change(function() {
		layoutselect();
	});

	$(".fontselect").change(function() {
		$("#"+ name + "_preview").remove();
		var font = $(this).val();
		var el = $(this).attr("rel");
		var name = $(this).attr("name");
		var addplus = font.replace(" ", "+");
		$("head").prepend("<link id='" + name + "_preview' href='http://fonts.googleapis.com/css?family=" + addplus + "' rel='stylesheet' type='text/css'>");
		$(el).css({ fontFamily : font }); 

	});
	
	$(".logo-input input").change(function() {
		var thesrc = $(this).val();
		$("#header_logo img").attr("src", thesrc);
	});

	function colorselect() {
		var value = $("#colorselect").val();
		$(".color-item").show().not("."+value+"-item").hide();	
	}
	colorselect();

	function layoutselect() {
		var value = $("#layoutselect").val();
		$(".addoption").show().not("."+value+"-item").hide();	
		if(value=="header") $(".header-inputs").show(); else $(".header-inputs").hide(); 
	}
	layoutselect();
	
	if($(".colorpicker").val()=="") $(".colorpicker").val("#")
	
	var f = $.farbtastic('#picker');
    $('.colorpicker')
    	.each(function() { f.linkTo(this); })
      	.focus(function() { f.linkTo(this);	})
		.change(function() { if($(this).val()=="") $(this).val("#"); change_styles(); });
	
	$(".farbtastic").mouseup(function() {
		change_styles();
		$("#savetheme").addClass("remember");
	});

	function change_styles() {
		$(".colorpicker:visible").each(function() {
			var col = $(this).val();
			var style = $(this).attr("rel").split('|');
			var addstyle = style[0] + " { " + style[1] + ": " + col + "; }\n";
			$("#pw_style_preview").append(addstyle);
		});	
	}

	$(".font-option").click(function() { 
		$(".font-option").removeClass("active");
		$("#new-font-style").remove();
		$(this).addClass("active");
		var theID = $(this).attr("id");
		$("input#font_option").val(theID);
		$("head").append('<link rel="stylesheet" type="text/css" href="<?php echo PW_THEME_URL; ?>/admin/css/' + theID + '.css" id="new-font-style" media="screen" />');
	});
	
	$(".colorwheel").click(function() {
		var el = $(this).attr("rel");
		$(this).parent().find("input").focus();	 
		$("#color").stop(true,true).animate({ width: 450 }, function() {
			$("#picker, #closepicker").fadeIn();
		});
	});
	
	$("#closepicker").click(function() {
		$("#picker, #closepicker").fadeOut('fast', function() {
			$("#color").stop().animate({ width: 250 });
		});

	});
	$("#body_font_size").change(function() {
		var size = $(this).val();
		var addstyle = "body { font-size: " + size + "px; }";
		$("#pw_style_preview").append(addstyle);

	});
	$(".add-item").click(function(){
		if($(this).hasClass("disabled")) {
			// nothing
		} else {
			var nonce = $("input#presswork_nonce").val();
			$(this).addClass("disabled");
			var loader = $("#ajaxloader");
			var wrap = $(this).attr("rel").split("|");
			var main = $("#"+wrap[0]);
			var item = $(this).attr("key");
			loader.show();
			var data = {
				action: 'add_element',
				element: item,
				option: wrap[1],
				nonce: nonce,
			};
			$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
			function(response){
				loader.hide();
				if(response) {
					main.append(response);
					var last = main.find("li#"+item);
					if(wrap[1]=="layout") {
						var newfull = last.outerWidth();
						var full = $("#body-wrapper").outerWidth();
						$("body").removeClass("fullwidth");
						$("#body-wrapper").stop(true,true).animate({
							width: full+newfull+30+"px"
						}, function() { last.show(); });	
					}				
					$("#"+wrap[1]+"_option").val( main.sortable("toArray") );
					$("#savetheme").addClass("remember");
				}
			});
		}
	});
		
	$(".save_option").click(function() {
		if($(this).hasClass("active")) {
			var value = "off";
		} else {
			var value = "on";
		}
		var theID = $(this).attr("id");
		var loader = $("#ajaxloader");
		loader.show();
		var data = {
			action: 'save_option',
			option: value,
			id: theID
		};
		$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
		function(response){
			setTimeout(function() { location.reload(); }, 1000);
		});
	});
	$("#reset_options").click(function() {
		var message = "Are you sure you want to reset the theme options?";
		if(confirm(message)) {
			var loader = $("#ajaxloader");
			loader.show();
			var data = {
				action: 'reset_theme_options'
			};
			$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
			function(response){
				setTimeout(function() { location.reload(); }, 1000);
			});
		} else {
			return false;
		}
	});
	$(".layout_widths").change(function(){
		var value = $(this).val();
		var id = $(this).attr("rel");
		var current = $("#"+id).width();
		var full = $("#body-wrapper").outerWidth();
		var newfull = parseInt(full) - parseInt(current) + parseInt(value);
		if(value>current) {
			$("#body-wrapper").stop(true,true).animate({
				width: newfull+"px"
				},
			function() { 
				$("#"+id).stop(true,true).animate({
					width: value+"px" 
				});				
			});
		} else {
			$("#"+id).stop(true,true).animate({
				width: value+"px" 
				},
			function() { 
				$("#body-wrapper").stop(true,true).animate({
					width: newfull+"px"
				});				
			});		
		}
	});

	$(".margins").change(function(){
		var value = $(this).val();
		var id = $(this).attr("rel");
		if(id!="body-wrapper") {
			var current = $("#"+id).css("margin-right").replace("px", "");
			var full = $("#body-wrapper").width();
			var newfull = parseInt(full) - parseInt(current*2) + parseInt(value);
			newvalue = "0 " + (value/2);
			if((value/2)>current) {
				$("#body-wrapper").stop(true,true).animate({
					width: newfull+"px"
					},
				function() { 
					$("#"+id).css({
						margin: newvalue+"px" 
					});				
				});
			} else {
				$("#"+id).css({
					margin: newvalue+"px" 
				});
				$("#body-wrapper").stop(true,true).animate({
					width: newfull+"px"
				});				
			}
		} else {
			$("#"+id).css({
				padding: value+"px"
			});
		}
	});
	
	$("#social .themeoptions input").change(function() { 
		var value = $(this).val();
		var el = $(this).attr('name');
		if(value=='') {
			$("#social-icons a."+el+"-icon").remove();
		} else if($("#social-icons a."+el+"-icon").length==0) {
			var theURL;
			if(el=="twitter") theURL = "http://twitter.com/"+value;
			if(el=="facebook") theURL = "http://facebook.com/"+value;
			if(el=="flickr") theURL = "http://flickr.com/photos/"+value;
			if(el=="linkedin") theURL = "http://www.linkedin.com/in/"+value;
			if(el=="stumbleupon") theURL = "http://www.stumbleupon.com/stumbler/"+value;
			if(el=="googleplus") theURL = "https://plus.google.com/"+value;
			$("#social-icons").append("<a href='"+theURL+"' class='"+el+"-icon'></a>");
		}
	});
	$(".open_toolbox").click(function() {
		var button = $(this);
		var it = $(this).attr("rel");
		var par = $("#"+it);
		if(button.hasClass("open")) {
			par.stop(true,true).fadeOut('fast');
			button.removeClass("open");
			return;
		}
		$(".open_toolbox").removeClass("open");
		button.addClass("open");
		if($(".pw_toolbox_content").not(par).is(".open")) {
			$(".pw_toolbox_content.open").fadeOut('fast', function() {
				if(!par.hasClass("open")) par.stop(true,true).fadeIn().addClass("open");
			}).removeClass("open");
		} else {
			par.stop(true,true).fadeIn().addClass("open");
		}
	});
	
	$(".closewindow").click(function() {
		$(".pw_toolbox_content").fadeOut('fast');	
		$(".open_toolbox").removeClass("open");
	});
<?php if(pw_theme_option("dragdrop")=="on") { ?>
	$(".delete_element").live("click", function(){
		var nonce = $("input#presswork_nonce").val();
		var loader = $("#ajaxloader");
		var main = $("#main-wrapper");
		loader.show();
		var el = $(this);
		var element = $(this).attr("key");
		var option = $(this).attr("rel");
		$('.add-item[key="'+element+'"]').removeClass("disabled");
		var data = {
			action: 'delete_element',
			element: element,
			option: option,
			nonce: nonce,
		};
		$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
		function(response){
			loader.hide();
			if(option=="layout_option") {
				var theitem = el.parent().parent();
				var newfull = theitem.outerWidth();
				var full = $("#body-wrapper").outerWidth();
				theitem.remove();
				$("#body-wrapper").stop(true,true).animate({
					width: full-newfull-30+"px"
				});
				var parent = "main-wrapper";
			}
			if(option=="header_option") {
				var theitem = el.parent().parent();
				theitem.remove();
				var parent = "headerbanner";
			}	
			if(option=="footer_option") {
				var theitem = el.parent().parent();
				theitem.remove();
				var parent = "footer";
			}
			$("#"+option).val( $("#"+parent).sortable("toArray") );
			$("#savetheme").addClass("remember");
		});
	});	
<?php } ?>
	$("#main-wrapper")
		.sortable({
			placeholder: 'placeholder',
			handle: "div.handle",
			forcePlaceholderSize: true,
			update: function(){
				$("#layout_option").val( $(this).sortable("toArray") );
			}

		})
	$("#headerbanner")
		.sortable({
			placeholder: 'placeholder',
			handle: "div.handle",
			forcePlaceholderSize: true,
			update: function(){
				$("#header_option").val( $(this).sortable("toArray") );
			}
		})
	$("#footer")
		.sortable({
			placeholder: 'placeholder',
			handle: "div.handle",
			forcePlaceholderSize: true,
			update: function(){
				$("#footer_option").val( $(this).sortable("toArray") );
			}
		})
		
	$("#themeform input, #themeform #fonts select").change(function() {
		$("#savetheme").addClass("remember");
	});
	
	// ask the user to confirm the window closing
	window.onbeforeunload = function() {
		if($('#savetheme').hasClass("remember")) {
			return "<?php _e("If you leave this page you will lose your changes.", "presswork"); ?>";
		}
	}
})(jQuery);
/* ]]> */
</script>
	<?php
}