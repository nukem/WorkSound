<?php 

function array_sort($array,$column){
	 $column = $column-1;
	 foreach($array as $line){
		 $bits = explode("||",$line);
		 $bits ="$bits[$column]**$line";
		 $array1[]=$bits;
		}
	 asort($array1);
	 foreach($array1 as $line){
		 $bit = explode("**",$line);
		 $bit ="$bit[1]";
		 $array2[]=$bit;
		}
	 return $array2;
}


$arr =array();

$arr[] = array ('12','2011-2-22','bb'); 

$arr[] = array ('12','2011-5-22','eee'); 

$arr[] = array ('12','2011-4-22','dd');

$arr[] = array ('12','2011-1-22','aaa'); 

$arr[] = array ('12','2011-2-22','bbb'); 

$arr[] = array ('12','2011-3-22','cc'); 


print_r($arr);

echo "<br><br><br><br>";

print_r(array_sort($arr,2));

?>
