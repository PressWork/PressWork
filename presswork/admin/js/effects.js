// HOVERINTENT
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity: 7,interval: 100,timeout: 0};cfg=$.extend(cfg,g?{over: f,out: g}: f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement : e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);

// SUPERFISH
;(function($){$.fn.superfish=function(op){var sf=$.fn.superfish,c=sf.c,$arrow=$(['<span class="',c.arrowClass,'">»</span>'].join('')),over=function(){var $$=$(this),menu=getMenu($$);clearTimeout(menu.sfTimer);$$.showSuperfishUl().siblings().hideSuperfishUl();},out=function(){var $$=$(this),menu=getMenu($$),o=sf.op;clearTimeout(menu.sfTimer);menu.sfTimer=setTimeout(function(){o.retainPath=($.inArray($$[0],o.$path)>-1);$$.hideSuperfishUl();if(o.$path.length&&$$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path);}},o.delay);},getMenu=function($menu){var menu=$menu.parents(['ul.',c.menuClass,':first'].join(''))[0];sf.op=sf.o[menu.serial];return menu;},addArrow=function($a){$a.addClass(c.anchorClass).append($arrow.clone());};return this.each(function(){var s=this.serial=sf.o.length;var o=$.extend({},sf.defaults,op);o.$path=$('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){$(this).addClass([o.hoverClass,c.bcClass].join(' ')).filter('li:has(ul)').removeClass(o.pathClass);});sf.o[s]=sf.op=o;$('li:has(ul)',this)[($.fn.hoverIntent&&!o.disableHI)?'hoverIntent' : 'hover'](over,out).each(function(){if(o.autoArrows)addArrow($('>a:first-child',this));}).not('.'+c.bcClass).hideSuperfishUl();var $a=$('a',this);$a.each(function(i){var $li=$a.eq(i).parents('li');$a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});});o.onInit.call(this);}).each(function(){var menuClasses=[c.menuClass];if(sf.op.dropShadows&&!($.browser.msie&&$.browser.version<7))menuClasses.push(c.shadowClass);$(this).addClass(menuClasses.join(' '));});};var sf=$.fn.superfish;sf.o=[];sf.op={};sf.IE7fix=function(){var o=sf.op;if($.browser.msie&&$.browser.version>6&&o.dropShadows&&o.animation.opacity!=undefined)this.toggleClass(sf.c.shadowClass+'-off');};sf.c={bcClass : 'sf-breadcrumb',menuClass : 'sf-js-enabled',anchorClass : 'sf-with-ul',arrowClass : 'sf-sub-indicator',shadowClass : 'sf-shadow'};sf.defaults={hoverClass	: 'sfHover',pathClass	: 'overideThisToUse',pathLevels	: 1,delay : 800,animation	:{opacity:'show'},speed : 'normal',autoArrows	: true,dropShadows : true,disableHI	: false,onInit : function(){},onBeforeShow: function(){},onShow : function(){},onHide : function(){}};$.fn.extend({hideSuperfishUl : function(){var o=sf.op,not=(o.retainPath===true)?o.$path : '';o.retainPath=false;var $ul=$(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass).find('>ul').hide().css('visibility','hidden');o.onHide.call($ul);return this;},showSuperfishUl : function(){var o=sf.op,sh=sf.c.shadowClass+'-off',$ul=this.addClass(o.hoverClass).find('>ul:hidden').css('visibility','visible');sf.IE7fix.call($ul);o.onBeforeShow.call($ul);$ul.animate(o.animation,o.speed,function(){sf.IE7fix.call($ul);o.onShow.call($ul);});return this;}});})(jQuery);

// SUPERSUBS
;(function($){$.fn.supersubs=function(options){var opts=$.extend({},$.fn.supersubs.defaults,options);return this.each(function(){var $$=$(this);var o=$.meta?$.extend({},opts,$$.data()): opts;var fontsize=$('<li id="menu-fontsize">—</li>').css({'padding' : 0,'position' : 'absolute','top' : '-999em','width' : 'auto'}).appendTo($$).width();$('#menu-fontsize').remove();$ULs=$$.find('ul');$ULs.each(function(i){var $ul=$ULs.eq(i);var $LIs=$ul.children();var $As=$LIs.children('a');var liFloat=$LIs.css('white-space','nowrap').css('float');var emWidth=$ul.add($LIs).add($As).css({'float' : 'none','width'	: 'auto'}).end().end()[0].clientWidth/fontsize;emWidth+=o.extraWidth;if(emWidth>o.maxWidth){emWidth=o.maxWidth;}else if(emWidth<o.minWidth){emWidth=o.minWidth;}emWidth+='em';$ul.css('width',emWidth);$LIs.css({'float' : liFloat,'width' : '100%','white-space' : 'normal'}).each(function(){var $childUl=$('>ul',this);var offsetDirection=$childUl.css('left')!==undefined?'left' : 'right';$childUl.css(offsetDirection,emWidth);});});});};$.fn.supersubs.defaults={minWidth : 9,maxWidth : 25,extraWidth : 0};})(jQuery);

(function($) {
	$("ul.sf-menu").supersubs({ 
		minWidth:    12,
		maxWidth:    27,
		extraWidth:  1
	}).superfish({ 
		delay:       200,
		speed:       250 
	});	

	
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