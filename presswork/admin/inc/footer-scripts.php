<?php
function footer_scripts() {
	?>	
<script type="text/javascript" src="<?php echo admin_url("js/farbtastic.js"); ?>"></script>
<script type="text/javascript">
/* <![CDATA[ */
jQuery.fn.blindToggle = function(speed, easing, callback) {
  return this.animate({left: parseInt(this.css('left')) <0 ? 0 : -700}, speed, easing, callback);
};

(function($) {
<?php global $pw_welcome; if($_GET['action']=="pw-activate" && empty($pw_welcome)) { ?>
	$("#close-welcome").click(function() {
		nonce = $("input#bavotasan_nonce").val();
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
		return false;
	});
	$("#themeform").submit(function() {
		nonce = $("input#bavotasan_nonce").val();
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
		if(value=="header") $(".logo-input").show(); else $(".logo-input").hide(); 
	}
	layoutselect();
	
	if($(".colorpicker").val()=="") $(".colorpicker").val("#")
	
	var f = $.farbtastic('#picker');
    $('.colorpicker')
    	.each(function() { f.linkTo(this); })
      	.focus(function() { f.linkTo(this);	})
		.change(function() { if($(this).val()=="") $(this).val("#"); });
		
	$("#pw-preview").click(function() {
		$(".colorpicker:visible").each(function() {
			var col = $(this).val();
			var style = $(this).attr("rel").split('|');
			var addstyle = style[0] + " { " + style[1] + ": " + col + "; }";
			$("#pw_style_preview").append(addstyle);
		});
	});
	$(".font-option").click(function() { 
		$(".font-option").removeClass("active");
		$("#new-font-style").remove();
		$(this).addClass("active");
		var theID = $(this).attr("id");
		$("input#font_option").val(theID);
		$("head").append('<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/admin/css/' + theID + '.css" id="new-font-style" media="screen" />');
	});
	
	$(".colorwheel").click(function() {
		var el = $(this).attr("rel");
		$(this).parent().find("input").focus();	 
		$("#color").stop().animate({ width: 450 }, function() {
			$("#picker, #closepicker").fadeIn();
		});
	});
	
	$("#closepicker").click(function() {
		$("#picker, #closepicker").fadeOut(function() {
			$("#color").stop().animate({ width: 260 });
		});

	});
	
	$(".add-item").click(function(){
		if($(this).hasClass("disabled")) {
			// nothing
		} else {
			nonce = $("input#bavotasan_nonce").val();
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
					var last = main.find("li:last");
					if(wrap[1]=="layout") {
						var newfull = last.outerWidth();
						var full = $("#body-wrapper").outerWidth();
						$("body").removeClass("fullwidth");
						$("#body-wrapper").stop().animate({
							width: full+newfull+30+"px"
						}, function() { last.show(); });	
					}				
					$("#"+wrap[1]+"_option").val( main.sortable("toArray") );
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
			$("#body-wrapper").stop().animate({
				width: newfull+"px"
				},
			function() { 
				$("#"+id).stop().animate({
					width: value+"px" 
				});				
			});
		} else {
			$("#"+id).stop().animate({
				width: value+"px" 
				},
			function() { 
				$("#body-wrapper").stop().animate({
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
			var full = $("#body-wrapper").outerWidth();
			var newfull = parseInt(full) - parseInt(current*2) + parseInt(value);
			newvalue = "0 " + (value/2);
			if((value/2)>current) {
				$("#body-wrapper").stop().animate({
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
					},
				function() { 
					$("#body-wrapper").stop().animate({
						width: newfull+"px"
					});				
				});				
			}
		} else {
			$("#"+id).css({
				margin: value+"px"
			});
		}
	});
	$(".open_toolbox").click(function() {
		var button = $(this);
		var it = $(this).attr("rel");
		var par = $("#"+it);
		if(button.hasClass("open")) {
			par.stop().fadeOut();
			button.removeClass("open");
			return;
		}
		$(".open_toolbox").removeClass("open");
		button.addClass("open");
		if($(".pw_toolbox_content").not(par).is(".open")) {
			$(".pw_toolbox_content.open").fadeOut('slow', function() {
				if(!par.hasClass("open")) par.stop().fadeIn().addClass("open");
			}).removeClass("open");
		} else {
			par.stop().fadeIn().addClass("open");
		}
	});
	
	$(".closewindow").click(function() {
		$(".pw_toolbox_content").fadeOut();	
	});
<?php if(theme_option("dragdrop")=="on") { ?>
	$(".delete_element").live("click", function(){
		nonce = $("input#bavotasan_nonce").val();
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
				var theitem = el.parent().parent().parent();
				var newfull = theitem.outerWidth();
				var full = $("#body-wrapper").outerWidth();
				theitem.remove();
				$("#body-wrapper").stop().animate({
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
		});
	});	
	$("#main-wrapper")
		.sortable({
			placeholder: 'placeholder',
			handle: "div.handle",
			forcePlaceholderSize: true,
			update: function(){
				$("#layout_option").val( $(this).sortable("toArray") );
			}

		})
		.disableSelection();
	$("#headerbanner")
		.sortable({
			placeholder: 'placeholder',
			handle: "div.handle",
			forcePlaceholderSize: true,
			update: function(){
				$("#header_option").val( $(this).sortable("toArray") );
			}
		})
		.disableSelection();	
	$("#footer")
		.sortable({
			placeholder: 'placeholder',
			handle: "div.handle",
			forcePlaceholderSize: true,
			update: function(){
				$("#footer_option").val( $(this).sortable("toArray") );
			}
		})
		.disableSelection();
<?php } ?>
})(jQuery);
/* ]]> */
</script>
	<?php
}