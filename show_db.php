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
				<li><a href='index.php'>Generate Invoice</a></li>
				<li><a href="new_prod.php">Add New Products</a></li>
				<li class="active"><a href='show_db.php'>Products List</a></li>
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
		<div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Sr. No.</th>
						<th>Product ID</th>
						<th>Product Name</th>
						<th>Product Price/Unit</th>
						<th>Delete Product</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$prod="select * from products";
						$rw=mysqli_query($link,$prod) or die(mysqli_errno()."in query $prod");
						$count=1;
						while($row=mysqli_fetch_assoc($rw))
						{

							
							echo "<tr>";
							echo "<td>".$count."</td>";
							echo "<td>".$row['prod_id']."</td>";
							echo "<td>".$row['prod_name']."</td>";
							echo "<td>".$row['prod_price']."</td>";
							echo "<td><form action='delete_prod.php' id='delete' method='get'>";
							echo "<input type='hidden' name='prod_id' value='".$row['prod_id']."' />";
							echo "<button type='submit' class='btn btn-default' name='delete'>Delete</button>";
							echo "</form></td>";
							$count=$count+1;						
						}
						
						mysqli_free_result($rw);
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
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
				<form role="form" method="post" name="login" action="show_db.php.php">
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
    $u_name=$_POST['username'];
    $password=mysqli_real_escape_string($link,$_POST['pass']);
    $password=mysqli_real_escape_string($link,$password);
    $w="select * from operators where operator_username = '$u_name' AND operator_pass = '$password'";
    $b=mysqli_query($link,$w) or die(mysqli_errorno()."in query $w");
    $num_rows = mysqli_num_rows($b);
    if($num_rows > 0)
    {
        $_SESSION["logged_in"]=true;
        $_SESSION["username"]=$_POST['username'];
       
        header('location:show_db.php');
    }
    else
    {
         echo "<script>
          alert('Your username or password is incorrect. Please try again'); window.location = 'show_db.php'; </script>";
    }
    mysqli_close($link);
}
}
?>