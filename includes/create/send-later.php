<?php include('../functions.php');?>
<?php include('../login/auth.php');?>
<?php include('../helpers/short.php');?>
<?php

	/*echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	exit;*/

	//get POST variables
	$timezone = mysqli_real_escape_string($mysqli, $_POST['timezone']);
	date_default_timezone_set($timezone);//set timezone
	$campaign_id = mysqli_real_escape_string($mysqli, $_POST['campaign_id']);
	$email_lists = mysqli_real_escape_string($mysqli, $_POST['email_lists']);
	$app = $_POST['app'];
	$send_date = mysqli_real_escape_string($mysqli, $_POST['send_date']);
	$total_recipients = $_POST['total_recipients2'];
	$hour = mysqli_real_escape_string($mysqli, $_POST['hour']);
	$min = mysqli_real_escape_string($mysqli, $_POST['min']);
	$ampm = mysqli_real_escape_string($mysqli, $_POST['ampm']);
	if($ampm=='pm' && $hour!=12)
		$hour += 12;
	if($ampm=='am' && $hour==12)
		$hour = 00;
	$send_date_array = explode('-', $send_date);
	$month = $send_date_array[0];
	$day = $send_date_array[1];
	$year = $send_date_array[2];
	$the_date = mktime($hour, $min, 0, $month, $day, $year);
	
	//create sql for exclude_lists
	$exclude_lists_update_sql = "";
	if (isset($_POST['email_lists_exclude']) && strlen($_POST['email_lists_exclude']) > 0)
	{
		//$exclude_lists_update_sql = ', exclude_lists = "'.implode(',', $exclude_lists_arr).'" ';
		$exclude_lists_update_sql = ', exclude_lists = "'.mysqli_real_escape_string($mysqli, $_POST['email_lists_exclude']).'" ';
	}
	
	//adding sql for storing exclude_lists
	$q = 'UPDATE campaigns SET send_date = "'.$the_date.'", lists = "'.$email_lists.'" '.$exclude_lists_update_sql.', timezone = "'.$timezone.'" WHERE id = '.$campaign_id;
	$r = mysqli_query($mysqli, $q);
	if ($r)
	{
		header("Location: ".get_app_info('path')."/app?i=".$app);
	}
	
	//Check if monthly quota needs to be updated
	$q = 'SELECT allocated_quota, current_quota FROM apps WHERE id = '.$app;
	$r = mysqli_query($mysqli, $q);
	if($r) 
	{
		while($row = mysqli_fetch_array($r)) 
		{
			$allocated_quota = $row['allocated_quota'];
			$current_quota = $row['current_quota'];
			$updated_quota = $current_quota + $total_recipients;
		}
	}
	//Update quota if a monthly limit was set
	if($allocated_quota!=-1)
	{
		//if so, update quota
		$q = 'UPDATE apps SET current_quota = '.$updated_quota.' WHERE id = '.$app;
		mysqli_query($mysqli, $q);
	}

?>
