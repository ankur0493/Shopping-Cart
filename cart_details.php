<?php
$cart_id=$_POST['q'];
include "connection.php";
$query="select product_id from cart_details where cart_id = $cart_id";
$result=mysqli_query($link,$query) or die(mysqli_error($link));
if($result && mysqli_num_rows($result)!=0)
{
	echo "<table class='table table-striped' id='table_invoice'>";
				echo "<thead>
					<tr>
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Product Price</th>
					</tr>
				</thead><tbody>";
	while($row=mysqli_fetch_array($result))
	{
		$prod_id = $row['product_id'];
		$prodDetail = "Select  * from products where prod_id = $prod_id";
		$prodResult = mysqli_query($link,$prodDetail) or die(mysqli_error($link));
		if(!$prodResult){
			echo "There was an error in fetching the product with product ID ".$prod_id;
		}
		else{
			if(mysqli_num_rows($prodResult)==0)
			{
				echo "There is no item in this cart";
			}
			else{
				while($prod=mysqli_fetch_array($prodResult)){
				$prod_name=$prod['prod_name'];
				$prod_price=$prod['prod_price'];
				echo "<tr><td><input type='text' class='form-control' name='prodId[]' value='".$prod_id."'></input></td>";
				echo "<td><input type='text' class='form-control' name=prodName[] value='".$prod_name."'></input></td>";
				echo "<td><input type='text' class='form-control' name=prodPrice[] value='".$prod_price."'></input></td></tr>";
				}
			}
		}
	}
	echo "</table";
}
else{
	echo "There is no item in this cart.";
}
?>