$(function(){
    
    // Hide URL Bar on iPhone and iPod Touch
    if(navigator.userAgent.indexOf('iPhone') != -1) {
        setTimeout(function () {
            if (!pageYOffset) {window.scrollTo(0, 1);}
        }, 1000);
    }
});

$(document).ready( function(){
	$("select, input:checkbox, input:radio, input:file").uniform();
	
	
	//tooltip
	$('.bubble_info').each(function () {
		// options
		var distance = 12;
		var time = 100;
		var hideDelay = 100;
		var hideDelayTimer = null;
	
		// tracker
		var beingShown = false;
		var shown = false;
		
		var trigger = $('.img_ask', this);
		var popup = $('.popup', this).css('opacity', 0);
	
		// set the mouseover and mouseout on both element
		$([trigger.get(0), popup.get(0)]).mouseover(function () {
		  // stops the hide event if we move from the trigger to the popup element
		  if (hideDelayTimer) clearTimeout(hideDelayTimer);
	
		  // don't trigger the animation again if we're being shown, or already visible
		  if (beingShown || shown) {
			return;
		  } else {
			beingShown = true;
	
			// reset position of popup box
			popup.css({
			  //bottom: 50,
			  //left: -65,
			  display: 'block' // brings the popup back in to view
			})
	
			// (we're using chaining on the popup) now animate it's opacity and position
			.animate({
			  //bottom: '-=' + distance + 'px',
			  opacity: 1
			}, time, 'swing', function() {
			  // once the animation is complete, set the tracker variables
			  beingShown = false;
			  shown = true;
			});
		  }
		}).mouseout(function () {
		  // reset the timer if we get fired again - avoids double animations
		  if (hideDelayTimer) clearTimeout(hideDelayTimer);
		  
		  // store the timer so that it can be cleared in the mouseover if required
		  hideDelayTimer = setTimeout(function () {
			hideDelayTimer = null;
			popup.animate({
			  //bottom: '-=' + distance + 'px',
			  opacity: 0
			}, time, 'swing', function () {
			  // once the animate is complete, set the tracker variables
			  shown = false;
			  // hide the popup entirely after the effect (opacity alone doesn't do the job)
			  popup.css('display', 'none');
			});
		  }, hideDelay);
		});
	  });
	  
	  $('.infotext').focus(function() {
		  if($(this).attr('title') == $(this).val()) $(this).val('');	  
	  });
	  
	   $('.infotext').blur(function() {
		  if($(this).val() == '') $(this).val($(this).attr('title'));	  
	  });
	  
	  $('.infotext').each(function() {
		  if($(this).val() == '') $(this).val($(this).attr('title'));
	  });
	
});