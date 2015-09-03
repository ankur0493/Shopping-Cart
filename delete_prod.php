<?php
if(isset($_GET['delete']))
{
	include "connection.php";
	$prod_id=$_REQUEST['prod_id'];
		$del="delete from products where prod_id=$prod_id";
	if (mysqli_query($link,$del))
	{
		echo "Successfully deleted";
		unset($_POST['delete']);
	}
	else
	{
		echo "Delete Operation Failed";
	}
	header('location:show_db.php');
}
?>