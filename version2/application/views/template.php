
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Soundbooka<?php echo (!empty($title) ? " - " . $title : ""); ?></title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="MSSmartTagsPreventParsing" content="true" />
    <meta name="author" content="Chathura Payagala" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="robots" content="index, follow" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css' />
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link rel="apple-touch-icon" href="<?= base_url() ?>apple-touch-icon.png">
    <link rel="stylesheet" href="<?= base_url() ?>css/jui/jquery-ui-1.8.16.custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/style.css?v=2">

	<script type="text/javascript">var BASE_URL = '<?= base_url() ?>';</script>
    <script src="<?= base_url() ?>js/libs/modernizr-1.7.min.js"></script>
    <script src="<?= base_url() ?>js/libs/respond.min.js"></script>

    <script src="<?= base_url() ?>js/libs/jquery-1.6.2.min.js"></script>
    <script src="<?= base_url() ?>js/jquery-ui-1.8.16.custom.min.js"></script>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="<?= base_url() ?>js/plugins.js"></script>
    <script src="<?= base_url() ?>js/script.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.floatingmessage.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jqdialog.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/ajaxfileupload.js"></script>
    <!-- end scripts-->

    <script type="text/javascript">

      function showError(msg) {
        var Errmsg = '<div class="ui-widget"><div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all flash"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> <strong>Error: </strong>&nbsp;' + msg + '</p></div></div>';
        $.floatingMessage(Errmsg ,{width : 500 });
      }
	  
	  function showErrorEx(msg) {
        Errmsg = '<div class="ui-widget"><div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all flash"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> <strong>Error: </strong>&nbsp;' + msg + '</p></div></div>';
        $.floatingMessage(Errmsg ,{width : 500, time : 5000 });
      }

      function showMessage(msg) {
        var msg = '<div class="ui-widget"><div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all flash"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span><strong>Success! </strong>&nbsp;' + msg + '</p></div></div>';
        $.floatingMessage(msg ,{width : 500, time : 5000 });
      }

      $(function() {
<? if (isset($form_errors) && !empty($form_errors)) : ?>
          showError('<?= ($form_errors) ?>');
<? endif; ?>

      });
    </script>   
  </head>
  <body>
    <div id="container">

      <?php $this->load->view('header'); ?>

      <div id="main" role="main" style="min-height:490px;margin:0px auto; text-align:center;">

        <article>
          <div id="content" style="min-height: 490px; text-align:left;">
			
            <?php $this->load->view($main_content); ?>
          </div>
        </article>
      </div>
      <?php $this->load->view('footer'); ?>

    </div>  
    <!--[if lt IE 7 ]>
    <script src="<?= base_url() ?>js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg');</script>
    <![endif]-->
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-29154056-1']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
    <?
    $Errors = $this->session->flashdata('error');
    $Messages = $this->session->flashdata('message');
    ?>

    <script type="text/javascript">
      $(document.body).ready(function(){
<? if ($Errors) : ?>	
          var Errmsg = '<div class="ui-widget"><div style="padding: 0pt 0.7em;" class="ui-state-error ui-corner-all flash"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> <strong>Error:</strong> <?= $Errors ?></p></div></div>';
          $.floatingMessage(Errmsg ,{width : 500 });
<? endif; ?>
<? if ($Messages) : ?>
          var msg = '<div class="ui-widget"><div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all flash"> <p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span><strong>Success!</strong> <?= $Messages ?></p></div></div>';
          $.floatingMessage(msg ,{width : 500, time : 5000 });
<? endif; ?>		
      });
    </script>
  </body>
</html>