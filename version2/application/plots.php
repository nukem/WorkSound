<?php
if(!empty($plots)){
	if(count($plots)==0) echo '<script>window.close();</script>';
	else if(count($plots)==1) {
		header("Location : ".$plots[0]['plot']);
		exit;
	}
	else if(count($plots)>1) {
		foreach($plots as $val){
			echo '<a href="'.$val->plot.'" target="_self">'.$val->plot.'</a><br><br>';
		}
	}
	else die( 'Query Error' );
}
?>