<?php
mysql_connect("localhost:3306","soundbooka_user","password123");
mysql_select_db("soundbooka");
//$result = mysql_query("select id from wp_structure where parent=$parent");

//del(2670);

/*	$result = mysql_query("select id from wp_structure where parent=189220");
	if(mysql_num_rows($result)){
		while($row = mysql_fetch_array($result)){
			mysql_query("update wp_structure set parent=189219 where id=$row[id]");
			}
	}
*/
function del($parent){
	$result = mysql_query("select id from wp_structure where parent=$parent");
	if(mysql_num_rows($result)){
		while($row = mysql_fetch_array($result)){
			del($row['id']);
			}
	}
	//echo "delete from wp_structure where parent=$parent and id != 191063".'<br>';
	mysql_query("delete from wp_structure where parent=$parent");
	mysql_query("delete from wp_structure where id=$parent");
}
//updateProperty(301);
function updateProperty($compid){
 $sql =  "select * from prop_details where cmscreated=1 and propid like '%$compid%' and compid=999999999  order by id desc";
 echo $sql;
 $result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){
		
		$propid = $row['id'].'-'.$compid;
		$sql = "update prop_details set propid='$propid', compid=301 where id=$row[id]";
		echo $sql;
		mysql_query($sql);
	}
}
?>