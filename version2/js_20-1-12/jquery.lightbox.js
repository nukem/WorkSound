$(function(){
	$('.lightbox_link').click(function(){
		$rel=$(this).attr('rel');
		$url=$(this).text();
		$fade=$('<div></div>').addClass('fade')
				.css({'opacity':'0.75', 'position':'fixed', 'z-index':9997, 'top':0, 'left':0, 'width':'100%', 'height':'100%', 'background-color':'#FFFFFF'});
		$close=$('<a></a>').addClass('close').html(' [ X ]').attr('href','javascript:void(0);')
				.css({'font-size':'19px', 'position':'fixed', 'z-index':9998, 'top':0, 'right':0, 'margin':'25px 25px 0 0'});
		$box=$('<div></div>').addClass('box')
				.css({'position':'fixed', 'z-index':9999, 'top':'75px', 'left':'35%', 'width':'33%', 'height':'120px', 'background-color':'#FFFFFF', 'border': '1px solid #333','padding':'10px','overflow':'auto'});
		
		$('body').append($fade).append($close).append($box);
		
		//$.post(base_url+'admin_jquery/view/'+$alt+'/'+$id,{},function(data){
		$.post(baseurl+'artist/audio'+$rel,{'url':$url},function(data){
			$box.append(data);
		});
		
		$('.fade, .close').click(function(){
			$fade.remove();
			$close.remove();
			$box.remove();
		});
	});
	$('.history_view').click(function(){
		  $id=$(this).parents('tr').attr('id');
		  //$alt=$(this).attr('alt');
		  $fade=$('<div></div>').addClass('fade')
			.css({'opacity':'0.75', 'position':'fixed', 'z-index':9997, 'top':0, 'left':0, 'width':'100%', 'height':'100%', 'background-color':'#FFFFFF'});
		  $close=$('<a></a>').addClass('close').html('<img width="25" src="'+ baseurl + 'images/window-close.png" />').attr('href','javascript:void(0);')
			.css({'font-size':'19px', 'position':'fixed', 'z-index':9998, 'top':0, 'right':0, 'margin':'53px 145px 0 0'});
		  $box=$('<div></div>').addClass('box')
			.css({'position':'fixed', 'z-index':9999, 'top':'75px', 'left':'20%', 'width':'65%', 'height':'50%', 'background-color':'#FFFFFF', 'border': '1px solid #333','padding':'10px','overflow':'auto'});
		  
		  $('body').append($fade).append($close).append($box);
		  
		  //$.post(base_url+'admin_jquery/view/'+$alt+'/'+$id,{},function(data){
		  $.post(baseurl + 'booka/histroy/' + $id ,{},function(data){
		   $box.append(data);
		  });
		  
		  $('.fade, .close').click(function(){
		   $fade.remove();
		   $close.remove();
		   $box.remove();
		  });
	 });
	$('.chat_view').click(function(){
	  $rel=$(this).attr('rel');
	  
	  $fade=$('<div></div>').addClass('fade')
		.css({'opacity':'0.75', 'position':'fixed', 'z-index':9997, 'top':0, 'left':0, 'width':'100%', 'height':'100%', 'background-color':'#FFFFFF'});
	  $close=$('<a></a>').addClass('close').html('<img width="25" src="'+ baseurl + 'images/window-close.png" />').attr('href','javascript:void(0);')
		.css({'font-size':'19px', 'position':'fixed', 'z-index':9998, 'top':0, 'right':0, 'margin':'53px 145px 0 0'});
	  $box=$('<div></div>').addClass('box')
		.css({'position':'fixed', 'z-index':9999, 'top':'75px', 'left':'20%', 'width':'65%', 'height':'50%', 'background-color':'#FFFFFF', 'border': '1px solid #333','padding':'10px','overflow':'auto'});
	  
	  $('body').append($fade).append($close).append($box);
	  
	  //$.post(base_url+'admin_jquery/view/'+$alt+'/'+$id,{},function(data){
	  $.post(baseurl + 'ajax/chat/' ,{'rel':$rel},function(data){
	   $box.append(data);
	  });
	  
	  $('.fade, .close').click(function(){
	   $fade.remove();
	   $close.remove();
	   $box.remove();
	  });
	});
	$('.artist_chat_view').click(function(){
	  $id=$(this).attr('id');
	  $rel=$(this).attr('rel');
	  
	  $fade=$('<div></div>').addClass('fade')
		.css({'opacity':'0.75', 'position':'fixed', 'z-index':9997, 'top':0, 'left':0, 'width':'100%', 'height':'100%', 'background-color':'#FFFFFF'});
	  $close=$('<a></a>').addClass('close').html('<img width="25" src="'+ baseurl + 'images/window-close.png" />').attr('href','javascript:void(0);')
		.css({'font-size':'19px', 'position':'fixed', 'z-index':9998, 'top':0, 'right':0, 'margin':'53px 145px 0 0'});
	  $box=$('<div></div>').addClass('box')
		.css({'position':'fixed', 'z-index':9999, 'top':'75px', 'left':'20%', 'width':'65%', 'height':'50%', 'background-color':'#FFFFFF', 'border': '1px solid #333','padding':'10px','overflow':'auto'});
	  
	  $('body').append($fade).append($close).append($box);
	  
	  //$.post(base_url+'admin_jquery/view/'+$alt+'/'+$id,{},function(data){
	  $.post(baseurl + 'booka/chat/' + $id ,{'rel':$rel},function(data){
	   $box.append(data);
	  });
	  
	  $('.fade, .close').click(function(){
	   $fade.remove();
	   $close.remove();
	   $box.remove();
	  });
	});
});
