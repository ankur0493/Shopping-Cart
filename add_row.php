<?php
$prod_id=$_POST['q'];
include "connection.php";
$a="select * from products where prod_id = $prod_id";
if($q=mysqli_query($link,$a))
{
	while($row=mysqli_fetch_assoc($q))
	{
		echo "<td><input type='text' class='form-control' name='prodId[]' value='".$row['prod_id']."'></input></td>";
		echo "<td><input type='text' class='form-control' name='prodName[]' value='".$row['prod_name']."'></input></td>";
		echo "<td><input type='text' class='form-control' name='prodPrice[]' value='".$row['prod_price']."'></input></td>";}
	}
else
{
	echo"Query Failed";
}
?>