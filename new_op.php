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
	<title>Register New Operator | SmartCart</title>
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
				<li><a href='show_db.php'>Products List</a></li>
				<li class="active"><a href="new_op.php">New Operator</a></li>
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
		<div>
		<br />
			Enter Product Details:<br />
			<form method="post" name="new_prod" action="new_op.php">
				<div class="form-group">
					<input type="text" name="op_id" class="form-control" placeholder="Enter Operator ID" >
				</div>
				<div class="form-group">
					<input type="text" name="op_name" class="form-control" placeholder="Enter Operator Name" >
				</div>
				<div class="form-group">
					<input type="text" name="op_username" class="form-control" placeholder="Enter Username" >	
				</div>
				<div class="form-group">
					<input type="password" name="op_pass" class="form-control" placeholder="Enter Password">
				</div>
				<button type="submit" class="btn btn-default" name="sub">Add Operator</button>	
			</form>
		</div>
	</div>
</body>
</html>
<?php
if(isset($_POST['sub']))
{
	$op_id=$_POST['op_id'];
	$op_name=$_POST['op_name'];
	$op_username=$_POST['op_username'];
	$op_pass=$_POST['op_pass'];
	$a="INSERT into operators (operator_id, operator_name, operator_username, operator_pass) VALUES ('$op_id', '$op_name', '$op_username', '$op_pass')";
	if (mysqli_query($link,$a))
		{
			echo "Operator succesfully registered";
		}
	else
	{
		$error=mysqli_error($link);
		echo "Operator registration failed.".$error;
	}
	mysqli_close($link);
}
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
				<form role="form" method="post" name="login" action="new_prod.php">
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
        header('location:new_op.php');
    }
    else
    {
         echo "<script>
          alert('Your username or password is incorrect. Please try again'); window.location = 'new_prod.php'; </script>";
    }
    mysqli_close($link);
}
}
?>