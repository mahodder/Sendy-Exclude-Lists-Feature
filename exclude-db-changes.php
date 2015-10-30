<?php include('includes/header.php');?>
<?php include('includes/login/auth.php');?>
<?php include('includes/create/main.php');?>
<?php include('includes/helpers/short.php');?>
<?php include('includes/create/timezone.php');?>
<?php
$q = 'ALTER TABLE `campaigns` ADD `exclude_lists` TEXT NULL ;';
$r = mysqli_query($mysqli, $q);
if ($r)
{
	echo 'Successfully applied changes to the database. <br />You can now delete file exclude-db-changes.php from your server.';
}
else
{
	$result = mysqli_query($mysqli, "SHOW COLUMNS FROM `campaigns` LIKE 'exclude_lists'");
	$column_exists = (mysqli_num_rows($result))?TRUE:FALSE;
	if ($column_exists)
	{
		echo 'Successfully applied changes to the database. <br />You can now delete file exclude-db-changes.php from your server.';
	}
	else
	{
		echo 'Unable to make changes to the database.';
	}
}

?>