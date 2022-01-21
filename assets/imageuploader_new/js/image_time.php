<?php
	include('../../config.php');
	include_once (INCLUDE_PATH."connection.php");
	include_once (INCLUDE_PATH."class.database.php");
	include_once (LIB_PATH."function.common.php");
	$db=new database();
	$datapost=$_REQUEST;
	if($datapost['type']=='insert')
		{
		//echo "insert into image_time set image_name='',start_time=now(),end_time='',car_id=".$_SESSION[iid]."";
			$lastId=$db->insertQuery("insert into image_time set image_detail='',start_time=now(),end_time='',car_id=".$_SESSION[iid]."");
			echo json_encode($lastId);exit;	
		
		}
	if($datapost['type']=='update')
		{
		//echo "insert into image_time set image_name='',start_time=now(),end_time='',car_id=".$_SESSION[iid]."";
			$lastId=$db->insertQuery("update image_time set image_detail=".$datapost[detail].",start_time=,end_time=now() where id=".$datapost[lastid]."");
			echo json_encode($lastId);exit;	
		
		}	
		
		
	?>
	
