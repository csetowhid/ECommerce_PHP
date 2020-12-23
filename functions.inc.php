<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_product($con,$limit='',$cat_id=''){
	$sql="select * from product where status=1";
	if($cat_id!=''){
		$sql.=" and categories_id=$cat_id ";
	}
	$sql.=" order by id desc";
	if($limit!='')
	{
		$sql.=" limit $limit";
	}
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
?>