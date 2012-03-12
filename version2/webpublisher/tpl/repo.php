<? require ("tpl/inc/head.php"); ?>
<body> 
<div id="page"> 
  <? require ("tpl/inc/header.php"); ?> 
  <? require ("tpl/inc/path.php"); ?> 
  <div id="content"> 
    <div id="left-col"> 
      <div id="left-col-border"> 
        <? if (isset ($errors)) require ("tpl/inc/error.php"); ?> 
        <? if (isset ($messages)) require ("tpl/inc/message.php"); ?> 
        <? if (isset ($_SESSION['epClipboard'])) require ("tpl/inc/clipboard.php"); ?> 
        <? require ("tpl/inc/structure.php"); ?> 
      </div> 
    </div> 
    <div id="right-col"> 
      <h2 class="bar green"><span><?= $lang[69] ?></span></h2> 
      <form action=".?id=<?= $id ?>" method="post"> 
        <? require ("tpl/inc/buttons.php"); ?> 
        <div class="right-col-padding1"> 
          <div class="width-99pct"> 
            <table class="rec-table"> 
              <? require ("tpl/inc/record.php"); ?>

<?php

$images = dbq('SELECT id, title FROM wp_structure WHERE parent = 3470 ORDER BY position');
$hl_packages = dbq('SELECT id, title FROM wp_structure WHERE parent = 3467 ORDER BY position');
$articles = dbq('SELECT id, title FROM wp_structure WHERE parent = 3465 ORDER BY position');

?>

				<tr>
					<td colspan="2">
						<label>Select an item to preview</label><br />
						<select id="item-selection" class="width-100pct textfield">

							<option></option>

							<optgroup label="Images">
<?php
foreach($images as $item) {
?>
								<option value="<?php echo $item['id']; ?>">
									<?php echo $item['title']; ?>
								</option>
<?php
}
?>
							</optgroup>
							<optgroup label="Brochures">
<?php
foreach($hl_packages as $item) {
?>
								<option value="<?php echo $item['id']; ?>">
									<?php echo $item['title']; ?>
								</option>
<?php
}
?>
							</optgroup>
							<optgroup label="Articles">
<?php
foreach($articles as $item) {
?>
								<option value="<?php echo $item['id']; ?>">
									<?php echo $item['title']; ?>
								</option>
<?php
}
?>
							</optgroup>

						</select>
					</td>
					<td> </td>
					<td> </td>
				</tr>

				<tr>
					<td colspan="4">

						<h2>Content</h2>
						<div class="content-container"></div>

					</td>
				</tr>

				<script type="text/javascript">
$(function () {

	$('#item-selection').change(function () {

		$('.content-container').html('').addClass('loading');

		$.ajax({
			url: '../content/view_repository_content/' + $(this).val(),
			type: 'post',
			success: function (data) {
				$('.content-container').html(data.html).removeClass('loading');
			},
			dataType: 'json'
		})
	
	});
	
})


				</script>

				<style type="text/css">

					.content-container {
						padding: 20px;
						border: 1px solid #ccc;

					}

					.content-container img {
						border: 1px solid #aaa;
						display: block;
					}

					.loading {
						background: url(img/loading.gif) no-repeat center center;
						height: 30px;
					}

				</style>


              
              <? require ("tpl/inc/rights.php"); ?> 
            </table> 
          </div> 
        </div> 
      </form> 
    </div> 
    <? require ("tpl/inc/footer.php"); ?> 
  </div> 
</div> 
</body>
</html>
