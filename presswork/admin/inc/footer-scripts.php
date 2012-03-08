<?php
/**
 * These are the jQuery scripts needed to run PressWork
 * so don't mess with this file
 *
 * @since PressWork 1.0
 */
if(!function_exists('pw_footer_scripts')) :
	function pw_footer_scripts() {
		echo "\n<!-- PressWork Toolbox Scripts -->";
		?>	
<script type="text/javascript">
/* <![CDATA[ */
(function($) {
<?php global $pw_welcome; if(!empty($_GET['action']) && $_GET['action']=="pw-activate" && empty($pw_welcome)) { ?>
	$("#close-welcome").click(function() {
		var nonce = $("input#presswork_nonce").val(),
			data = {
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
		if(!pos)
			pos = $("#wp-admin-bar-presswork-menu").position();
		$(".adminbar-arrow").css({ left: pos.left-30 }).show();
	});
<?php } ?>
	$("#savetheme").click(function() {
		$("#themeform").trigger("submit");
		$(this).removeClass("remember");
		return false;
	});
	$("#themeform").submit(function() {
		var nonce = $("input#presswork_nonce").val(),
			loader = $("#ajaxloader"),
			message = $("#save_message"),
			data = {
				action: 'save_theme_options',
				nonce: nonce,
				option: $(this).serialize(),
			};
		message.hide();
		loader.show();
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

    $('.font-select a').click(function() {
		var section_to_show = $(this).next(),
			already_visible = $('.font-preview:visible');
		section_to_show.slideToggle('slow');
		already_visible.slideUp('slow');
	});
    
    $(".font-preview a").bind({
		click: function(){
			var el = $(this),
				fontSelect = el.parents('.font-select'),
				fontPreview = el.parents('.font-preview'),
				thisText = el.text();
			fontSelect
				.children('a.current').text(thisText).css('font-family', thisText)
				.end()
				.children('input').val(thisText);
			fontPreview	
				.children('a.selected').removeClass('selected')
				.end()
				.parents('.font-preview').slideUp('slow');
			el.addClass('selected');		
		},
		mouseenter: function(){
			var el = $(this),
				to_style = el.parents('.font-select').children('a.current').data("pw-selectors"),
				this_font = el.text();
			//console.log('to_style: ' + to_style + ', this_font: ' + this_font);
			if(!el.parent('.font-preview').is(':animated'))
				$(to_style).css({ fontFamily : this_font });
		},
		mouseleave: function(){
			var el = $(this),
				current = el.parents('.font-select').children('a.current'),
				to_style = current.data("pw-selectors"),
				original_option = current.text();
			// console.log('to_style: ' + to_style + ', original_option: ' + original_option);
			if(!el.parent('.font-preview').is(':animated'))
				$(to_style).css({ fontFamily : original_option});
		}
	});
	
	$("#the_header_logo").change(function() {
		$("#header_logo img").attr("src", $(this).val());
	});

	function colorselect() {
		$(".color-item").show().not("." + $("#colorselect").val() + "-item").hide();	
	}
	colorselect();

	function layoutselect() {
		var value = $("#layoutselect").val();
		$(".addoption").show().not("."+value+"-item").hide();	
		$("."+value+"-inputs").show(); 
		$(".pw-inputs").not("."+value+"-inputs").hide(); 
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
			var el = $(this),
				col = el.val(),
				style = el.data("pw-selectors").split('|'),
				addstyle = style[0] + " { " + style[1] + ": " + col + "; }\n";
			$("#pw_style_preview").append(addstyle);
		});	
	}

	$("#body_font_size").change(function() {
		var size = $(this).val();
		$('body').css("font-size", size+"px");
	});
	$(".add-item").click(function(){
		var el = $(this);
		if(el.hasClass("disabled")) {
			// nothing
		} else {
			el.addClass("disabled");
			var nonce = $("input#presswork_nonce").val(),
				loader = $("#ajaxloader"),
				wrap = el.data("pw-selectors").split("|"),
				main = $("#"+wrap[0]),
				item = el.data("pw-ids"),
				data = {
					action: 'add_element',
					element: item,
					option: wrap[1],
					nonce: nonce,
				};
			loader.show();
			$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
			function(response){
				loader.hide();
				if(response) {
					main.append(response);
					if(wrap[1]=="layout") {
						var last = main.find("li#"+item),
							newfull = parseInt($('.layout_widths[data-pw-ids="'+item+'"]').val()),
							contentMargins = parseInt($('#content_margins').val()),
							bodyWrapper = $("#body-wrapper"),
							full = bodyWrapper.width(),
							total_new = full + newfull + contentMargins;
						last.css({ margin: "0 "+contentMargins/2+"px", width: newfull });
						$("body").removeClass("fullwidth");
						bodyWrapper.stop(true,true).animate({
							width: total_new
						}, function() { last.show(); });
						$("#headerbanner, #footer").animate({ width: total_new });	
						$("#header_image").animate({ backgroundSize: total_new });
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
		var theID = $(this).attr("id"),
			loader = $("#ajaxloader"),
			data = {
				action: 'save_option',
				option: value,
				id: theID
			};
		loader.show();
		$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
		function(response){
			setTimeout(function() { location.reload(); }, 1000);
		});
	});
	$("#reset_options").click(function() {
		var message = "Are you sure you want to reset the theme options?";
		if(confirm(message)) {
			var loader = $("#ajaxloader"),
				data = {
					action: 'reset_theme_options'
				};
			loader.show();
			$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
			function(response){
				setTimeout(function() { location.reload(); }, 1000);
			});
		} else {
			return false;
		}
	});
	$(".layout_widths").change(function(){
		var value = $(this).val(),
			id = $(this).data("pw-ids"),
			current = $("#"+id).width(),
			bodyWrapper = $("#body-wrapper"),
			headerFooter = $("#headerbanner, #footer"),
			headerImage = $("#header_image"),
			full = bodyWrapper.width(),
			newfull = parseInt(full) - parseInt(current) + parseInt(value);
		if(value>current) {
			bodyWrapper.stop(true,true).animate({
				width: newfull
				},
			function() { 
				$("#"+id).stop(true,true).animate({
					width: value 
				});	
				headerFooter.animate({ width: newfull });
				headerImage.animate({ backgroundSize: newfull });			
			});
		} else {
			$("#"+id).stop(true,true).animate({
				width: value 
				},
			function() { 
				bodyWrapper.stop(true,true).animate({
					width: newfull
				});		
				headerFooter.animate({ width: newfull });			
				headerImage.animate({ backgroundSize: newfull });			
			});		
		}
	});

	$(".margins").change(function(){
		var value = $(this).val(),
			id = $(this).data("pw-ids");
		if(id!="body-wrapper") {
			var bodyWrapper = $("#body-wrapper"),
				headerFooter = $("#headerbanner, #footer"),
				headerImage = $("#header_image"),
				current = $("#"+id).css("margin-right").replace("px", ""),
				full = bodyWrapper.width(),
				n = $("#"+id).length-1,
				newfull = parseInt(full) - (parseInt(current*2)* n) + (parseInt(value)* n),
				newvalue = "0 " + (value/2);
			if((value/2)>current) {
				bodyWrapper.stop(true,true).animate({
					width: newfull
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
				bodyWrapper.stop(true,true).animate({
					width: newfull
				});				
			}
			headerFooter.animate({ width: newfull });			
			headerImage.animate({ backgroundSize: newfull });					
		} else {
			$("#"+id).css({
				padding: value+"px"
			});
		}
	});
	
	$("#social .themeoptions input").change(function() { 
		var value = $(this).val(),
			el = $(this).attr('name');
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
		var button = $(this),
			it = $(this).data("pw-toolbox-name"),
			par = $("#"+it);
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
		var nonce = $("input#presswork_nonce").val(),
			loader = $("#ajaxloader"),
			main = $("#main-wrapper"),
			el = $(this),
			element = $(this).data("pw-ids"),
			option = $(this).data("pw-selectors"),
			data = {
				action: 'delete_element',
				element: element,
				option: option,
				nonce: nonce,
			};
		loader.show();
		$('.add-item[data-pw-ids="'+element+'"]').removeClass("disabled");
		$.post('<?php echo admin_url('admin-ajax.php'); ?>', data,
		function(response){
			loader.hide();
			if(option=="layout_option") {
				var theitem = el.parent().parent(),
					newfull = theitem.width(),
					bodyWrapper = $("#body-wrapper"),
					full = bodyWrapper.width(),
					new_width = full - newfull - parseInt($('#content_margins').val());
				theitem.remove();
				$("#header_image").animate({ backgroundSize: new_width });
				bodyWrapper.stop(true,true).animate({
					width: new_width
				}, 
				function() {
					$("#headerbanner, #footer").css({ width: new_width });	
				});
				var parent = "main-wrapper";
			}
			if(option=="header_option") {
				var theitem = el.parent().parent(),
					parent = "headerbanner";
				theitem.remove();
			}	
			if(option=="footer_option") {
				var theitem = el.parent().parent(),
					parent = "footer";
				theitem.remove();
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
<!-- eof PressWork Toolbox Scripts -->
		<?php
	}
endif;