<?php
include "connection.php";
$invoice_id=$_POST['invoice_id'];
$invoice_id = mysqli_real_escape_string($link,$invoice_id);
$cust_name = $_POST['cust_name'];
$cust_name= mysqli_real_escape_string($link,$cust_name);
$cust_tel = $_POST['cust_tel'];
$cust_tel = mysqli_real_escape_string($link,$cust_tel);
$cust_add = $_POST['cust_add'];
$cust_add = mysqli_real_escape_string($link,$cust_add);
$prodId= $_POST['prodId'];
$prodName= $_POST['prodName'];
$prodPrice= $_POST['prodPrice'];
$count = count($prodId);
$total= array_sum($prodPrice);
$date=date("Y-m-d");
$date = mysqli_real_escape_string($link,$date);
date_default_timezone_set('Asia/Kolkata');
$time=date('H:i:s');
$time=mysqli_real_escape_string($link,$time);
echo "Total Items: ".$count."<br />";
echo "Invoice total: ".$total."<br />";
echo "Thank You for shopping with us.";
$query = "insert into invoices (invoice_id, cust_name, cust_tel, invoice_date, invoice_time, invoice_total) values ('$invoice_id','$cust_name','$cust_tel','$date','$time','$total')";
mysqli_query($link,$query) or die(mysqli_error($link));
?>