/*!
 * Floating Message v1.0.1
 * http://sideroad.secret.jp/
 *
 * Copyright (c) 2009 sideroad
 *
 * Dual licensed under the MIT licenses.
 * Date: 2009-08-18
 */
//Floating Message Plugin
(function($) {
    var range = {
		top: {
			left: 10,
			right: 10
		},
		bottom : {
			left : 10,
			right : 10
		}
	};
	var right = 10;
	var fContainer = [];
	var scrollTop = 0;
	
	$(document).ready(function(){
		scrollTop = $(window).scrollTop();
	    $(window).scroll(function(){
	        scrollTop = $(window).scrollTop();
            for(i=0;i<fContainer.length;i++) {
                var animate = {};
                var e = fContainer[i];
                animate[e.verticalAlign] = e.range;
                if(e.verticalAlign == "top") animate[e.verticalAlign]+=scrollTop;
                else animate[e.verticalAlign]-=scrollTop;
                    
                e.f.animate(animate,{
                    duration: e.moveEaseTime,
                    easing: e.moveEasing,
                    queue: false
                });
            }
	    });
	});
	
    $.floatingMessage = function(message,options) {  
        options = options || {};
	
	    //default setting
        options = $.extend({
            verticalAlign : "top",
            align : "left",
			width : 300,
			height : 50,
			time : false,
			show : "drop",
			hide : "drop",
			padding : 10,
			margin : 10,
			stuffEaseTime : 1000,
			stuffEasing : "easeOutBounce",
			moveEaseTime : 500,
			moveEasing   : "easeInOutCubic",
			element : $("<div></div>"),
			onClose : false
        }, options);
        
		
		var f = $("<div></div>").attr({
			id : "jqueryFloatingMessage"+new Date().getTime()
		})
        .addClass("ui-widget-content")
        .addClass("ui-corner-all")
		.addClass("floating-message");
		
		
        
        var o = $.extend(true,{},options);
		$.extend(o,{
            f:f,
            range:range[o.verticalAlign][o.align]
        });
		
        if (message) o.element.html(message.replace(/\n/g,"<br />"));
		
        var css = {
            width : o.width+"px",
            height : o.height+"px",
            position : "absolute",
            padding : o.padding + "px"
        };
        css[o.verticalAlign] = range[o.verticalAlign][o.align];
        css[o.align] = right;
        if (o.verticalAlign == "top") {
            css[o.verticalAlign] += scrollTop;
        } else {
            css[o.verticalAlign] -= scrollTop;
        }
        f.css(css)
        .append(o.element);
		
        var timerId = false;
		var remove = function(){
			if(timerId) clearTimeout(timerId);
            var e;
            var animate = {};
            var deleteIndex;
			var orange = (o.height + o.margin + (o.padding*2));
            for(i=0;i<fContainer.length;i++) {
                e = fContainer[i];
                if(o === e) deleteIndex = i;
                if(e.range > o.range && e.align == o.align && e.verticalAlign == o.verticalAlign) {
                    e.range -= orange;
					if(e.range < 0) e.range=0;
                    animate[e.verticalAlign] = e.range;
                    if(e.verticalAlign == "top") animate[e.verticalAlign]+=scrollTop;
                    else animate[e.verticalAlign]-=scrollTop;
                    e.f.animate(animate,{
                        duration: o.stuffEaseTime,
                        easing: o.stuffEasing,
                        queue : false
                    });
                }
            }
            fContainer.splice(deleteIndex,1);
            range[o.verticalAlign][o.align] -= (o.height + o.margin + (o.padding*2));
			if(range[o.verticalAlign][o.align] < 0) range[o.verticalAlign][o.align] = 10;
            f.hide(o.hide,function(){
                $(this).remove;
				if(o.onClose) o.onClose();
            });
        };
        if (o.time) {
			timerId = setTimeout(remove,o.time);
		}
		f.bind("click",remove);
		
		$(document.body).append(f);
		f.show(o.show);
		fContainer.push(o);
		range[o.verticalAlign][o.align] += (o.height + o.margin + (o.padding * 2));
		
    }
	
	$.fn.floatingMessage = function(options){
		options = options || {};
		options.element = this;
		$.floatingMessage(false,options);
	}
})(jQuery);