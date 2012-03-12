<div style="background-image:none;min-height:300px">
<h1><?=$title?></h1>
	
<p>
<ul class="single_list">    
<? foreach ($faqs as $q) : ?>
<li><span style="font-size:15px;font-weight:bold;"><?php echo ascii_to_entities($q->faq_title);?></span>
<ul><li style="background-image:none;margin:10px 0px"><?php echo ascii_to_entities($q->description);?></li></ul>
</li>
<? endforeach; ?>
</ul>
</p>
</div>
<br class="cl" />