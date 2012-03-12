<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="ProjectName" />
<meta name="keywords" content="ProjectName" />
<title>Soundbooka<?php echo (!empty($title) ? " - " . $title : ""); ?></title>
<link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/style-inner.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/font/stylesheet.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?= base_url() ?>css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lte IE 6]>
	<script type="text/javascript" src="js/dd_belatedpng_0.0.8a-min.js"></script>
	<script type="text/javascript" src="js/iefix.js"></script>
<![endif]-->
<!--[if lte IE 7]>
	<link href="css/ie.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/main.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/curvycorners.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/jquery.jscrollpane.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/jquery.mousewheel.js" type="text/javascript"></script>
<script type="text/javascript">
		$(function()
			{
				$('.scroll-pane').jScrollPane(
					{
						showArrows: true
					}
				);
			});
</script>
</head>
<body>
		<div id="outer-wrapper">
				<div id="header-container">
						<div id="header">
								<h1 id="logo"><a href="<?= base_url() ?>"><img src="<?= base_url() ?>images/logo.png" alt="sound booka" width="237" height="36" /></a></h1>
						</div>
				</div><!-- end header -->
				<div id="mainbody">
					
					<?php $this->load->view($main_content); ?>			

					<div class="clear"></div>
				</div><!-- end mainbody -->
		</div><!-- end outer wrapper -->
</body>
</html>