<script type="text/javascript" src="<?php echo base_url(); ?>js/audio-player.js"></script>  
<script type="text/javascript">  
	AudioPlayer.setup("<?php echo base_url(); ?>swf/player.swf", {  
		width: 405,animation : 'no'
	});  
</script>  

<p id="audioplayer_1">&nbsp;</p>  
<script type="text/javascript">  
AudioPlayer.embed("audioplayer_1", {soundFile: "<?=$url ?>", autostart: "yes"}); 
</script>