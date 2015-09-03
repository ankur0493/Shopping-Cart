<?php
session_start();
error_reporting(-1);
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]==true)
{
$username=$_SESSION["username"];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Smart Shopping Cart System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<style type="text/css">
	.show-grid{
		background:#E0E0E0;
		}</style>
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
	function inputValue(row_id,value){
		$('#'+row_id).find('button').attr('value',value);
		}
	function jsFunction(sender){
        var tr = sender.parentNode.parentNode;
        return tr.getAttribute('id');
    }
	$(document).ready(function () {
        var counter = 1;
        $("#add_row").click(function () {
            var row_id = "row" + counter;
            new_elem = $("#new_row").clone().appendTo("#table_invoice tbody").show().attr("id", row_id);
            var button_id = "button" + counter;
            var input_id = "input" + counter; 
            $('#'+row_id).find('button').attr('id',button_id);
            $('#'+row_id).find('input').attr('id',input_id);
            counter++;
        });
    });
    function cartDetails(cartId){
    		$.ajax({
    		url: "cart_details.php",
    		type: "post",
    		data: {'q':cartId},
    		success: function(data){
    			$(document.getElementById('cart_details')).html(data);
    		},
    		error:function(){
    			$(document.getElementById('cart_details')).html("There is error while submit.");
    		}
    	})
    }
	function addprod(prodid,rowid) {
			$.ajax({
            url: "add_row.php",
            type: "post",
            data: {'q':prodid},
            success: function(data){	
                $(document.getElementById(rowid)).html(data);
            },
            error:function(){
                $(document.getElementById(rowid)).html('There is error while submit');
            }
        });
     }
     jQuery(document).ready(function(){
     	jQuery('.invoice').submit(function(){
     		if(!(this.cust_name.value== "") && !(this.cust_tel.value == "") && !(this.cust_add.value == "")){
		     	$.ajax({
		     		url     : $(this).attr('action'),
	            	type    : $(this).attr('method'),
		     		data    : $(this).serialize(),
		     		success: function(data){
		     			$(document.getElementById('invoiceTotal')).html(data);
		     		},
		     		error:function(){
		     			$(document.getElementById('invoiceTotal')).html('Error');
		     		}
		     	});
		     }
		     else{
		     	$(document.getElementById('invoiceTotal')).html('Please fill in all values');
		     }
	     	return false;
     	});
     });
	</script>
</head>
<body>
<?php
include "connection.php"
?>
	<div class="navbar navbar-default">
		<div class="container">
			<div class="navbar-brand">
				<a href='index.php'>SmartCart</a>
			</div>
			<ul class="nav navbar-nav tab">
				<li class="active"><a href='index.php'>Generate Invoice</a></li>
				<li><a href="new_prod.php">Add New Products</a></li>
				<li><a href='show_db.php'>Products List</a></li>
				<li><a href="new_op.php">New Operator</a></li>
			</ul>
			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>	
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row show-grid">
			<div class="col-md-12">
			<strong>Operator Details:</strong>
			<br />
			Name: <?php
			$a="select * from operators where operator_username='$username'";
			$w=mysqli_query($link,$a);
			if(!$w)
			{
				die(mysqli_errorno());
			}
			else{
				while($row=mysqli_fetch_array($w,MYSQLI_BOTH))
				{
					echo $row['operator_name'];
					?>
					<br />
					Operator ID: 	
					<?php
					echo $row['operator_id'];
				}
			}
			?>
			</div>
		</div>
		<br />
		<form role="form" name="invoice" method="post" action="invoice.php" class="invoice">
			<div class="row show-grid">
				<div class="col-md-5">
					<br />
					Date: 
					<?php 
					$date=date("d F, Y");
					echo $date; ?>
					<input type="text" class="form-control" name="cust_name" placeholder="Customer Name Here"/><br />
					<input type="tel" class="form-control" name="cust_tel" placeholder="Customer Contact Number"><br />
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-5">
					<br />
					Invoice ID:
					<?php 
					$invoice_que = "SELECT invoice_id from invoices order  by invoice_id DESC LIMIT 1";
					$invoice_result=mysqli_query($link,$invoice_que);
					$invoice_id=mysqli_fetch_assoc($invoice_result);
					if($invoice_id['invoice_id'])
					{
						$invoice_id=$invoice_id['invoice_id']+1;
					}
					else
					{
						$invoice_id = "0001";
					}
					echo $invoice_id;
					echo "<input type='hidden' name='invoice_id' value='".$invoice_id."' />";
					?>
					<textarea class="form-control" name="cust_add" rows="3" placeholder="Enter address Here"></textarea> <br />
				</div>
			</div><br />
					<div id="cart_details">
					<input type="text" class="form-control" placeholder="Enter Cart ID" onkeyup="inputValue('cart_details',this.value)" />
					<button type="button" class="btn btn-default" onclick="cartDetails(this.value)">Get Cart Details</button>
					</div>
					<table class="table table-striped">
					<tr id ="new_row" style="display:none;">
						<td><input type="text" class="form-control" placeholder="Enter Product ID"  onkeyup="inputValue(jsFunction(this),this.value)" /></td>
						<td><button type="button" class="btn btn-default" onclick="addprod(this.value,jsFunction(this))">Add Product</button></td>
					</tr>
					</table>
			<a id="add_row" class="btn bt-default">Add New Row</a>
			<span id="newprod"></span>
		<button type="submit" class="btn btn-default" name="submit_form">Generate Invoice</button>	
		</form>
		<br />
		<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4  show-grid" id="invoiceTotal"></div>
		<div class="col-md-4"></div>
		</div>
	</div
></body>
</html>
<?php
}
else
{
	?>
	<html>
<head>
	<title>Log In | SmartCart</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	<div class="navbar navbar-default">
		<div class="container">
			<div class="navbar-brand">
				SmartCart
			</div>
		</div>
	</div>
	<div class="container">
		<br />
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<form role="form" method="post" name="login" action="index.php">
		  			<div class="form-group">
					    <label for="username">Operator Username</label>
					    <input type="username" class="form-control" name="username" placeholder="Enter your username">
					</div>
					<div class="form-group">
					    <label for="pass">Password</label>
					    <input type="password" class="form-control" name="pass" placeholder="Password">
					</div>
		  			<button type="submit" class="btn btn-default" name="sub">Submit</button>
				</form>
			</div>
			<div class="col-md-3">
			</div>
		</div>
	</div>
</body></html>
	<?php
	include "connection.php";
if(isset($_POST['sub']))
{
    $u_name=mysqli_real_escape_string($link,$_POST['username']);
    $password=mysqli_real_escape_string($link,$_POST['pass']);
    $w="select * from operators where operator_username = '$u_name' AND operator_pass = '$password'";
    $b=mysqli_query($link,$w) or die(mysqli_errorno()."in query $w");
    $num_rows = mysqli_num_rows($b);
    if($num_rows > 0)
    {
        $_SESSION["logged_in"]=true;
        $_SESSION["username"]=$_POST['username'];
        header('location:index.php');
    }
    else
    {
         echo "<script>
          alert('Your username or password is incorrect. Please try again'); window.location = 'index.php'; </script>";
    }
}
}
?>