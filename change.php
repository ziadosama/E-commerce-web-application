<?php
	session_start();
	include_once 'dbconnect.php';
	$bs=$_GET['bs'];

	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	$userID=$_SESSION['userSession'];
	
	if (isset($_POST['btn-save'])) {
		$name=strip_tags($_POST['name']);
		$phone=strip_tags($_POST['phone']);
		$email=strip_tags($_POST['email']);
		$password=strip_tags($_POST['password']);
		$password2=strip_tags($_POST['password2']);
		
		if($password!=$password2){
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span>  ; Mismatching passwords !
				</div>";
		}
		else{
			$name=$DBcon->real_escape_string($name);
			$phone=$DBcon->real_escape_string($phone);
			$email=$DBcon->real_escape_string($email);
			$password=$DBcon->real_escape_string($password);
			
			$hashed_password=password_hash($password, PASSWORD_DEFAULT);
			if($bs=='b'){
				if(!empty($name)){
					$update = $DBcon->query("UPDATE buyer SET buyerName= '$name' WHERE buyerID=".$_SESSION['userSession']);
				}
				
				if(!empty($phone)){
					$update = $DBcon->query("UPDATE buyer SET buyerPhone= '$phone' WHERE buyerID=".$_SESSION['userSession']);
				}
				
				if(!empty($email)){
					$update = $DBcon->query("UPDATE buyer SET buyerEmail= '$email' WHERE buyerID=".$_SESSION['userSession']);
				}
				
				if(!empty($password)){
					$update = $DBcon->query("UPDATE buyer SET buyerPwd= '$hashed_password' WHERE buyerID=".$_SESSION['userSession']);
				}
			}
			else if($bs=='s'){
				if(!empty($name)){
					$update = $DBcon->query("UPDATE seller SET sellerName= '$name' WHERE sellerID=".$_SESSION['userSession']);
				}
				
				if(!empty($phone)){
					$update = $DBcon->query("UPDATE seller SET sellerPhone= '$phone' WHERE sellerID=".$_SESSION['userSession']);
				}
				
				if(!empty($email)){
					$update = $DBcon->query("UPDATE seller SET sellerEmail= '$email' WHERE sellerID=".$_SESSION['userSession']);
				}
				
				if(!empty($password)){
					$update = $DBcon->query("UPDATE seller SET sellerPwd= '$hashed_password' WHERE sellerID=".$_SESSION['userSession']);
				}
			}
		}
	}
	
	if(isset($_POST['btn-buyer'])){
		$query=$DBcon->query("SELECT  sellerEmail FROM seller WHERE sellerID='$userID'");
		$row=$query->fetch_array();
		$check_email=$DBcon->query("SELECT  * FROM buyer WHERE buyerEmail='$row[sellerEmail]'");
		$count=$check_email->num_rows;
		if($count==0){
			$query=$DBcon->query("SELECT  * FROM seller WHERE sellerID='$userID'");
			$row=$query->fetch_array();
			$query=$DBcon->query("INSERT INTO buyer(buyerPhone,buyerName,buyerEmail,buyerPwd) VALUES('$row[sellerPhone]','$row[sellerName]','$row[sellerEmail]','$row[sellerPwd]')");
			$ID=$DBcon->insert_id;
			$_SESSION['userSession']=$ID;
		} else{
			$query=$DBcon->query("SELECT  buyerID FROM buyer WHERE buyerEmail='$row[sellerEmail]'");
			$result=$query->fetch_array();
			$_SESSION['userSession']=$result['buyerID'];
		}
		header("Location:change.php?bs=b");
	}
	
	if(isset($_POST['btn-seller'])){
		$query=$DBcon->query("SELECT * FROM buyer WHERE buyerID='$userID'");
		$row2=$query->fetch_array();
		$check_email=$DBcon->query("SELECT  * FROM seller WHERE sellerEmail='$row2[buyerEmail]'");
		$count=$check_email->num_rows;
		if($count==0){
			$query=$DBcon->query("SELECT  * FROM buyer WHERE buyerID='$userID'");
			$row3=$query->fetch_array();
			$query=$DBcon->query("INSERT INTO seller(sellerPhone,sellerName,sellerEmail,sellerPwd) VALUES('$row3[buyerPhone]','$row3[buyerName]','$row3[buyerEmail]','$row3[buyerPwd]')");
			$ID=$DBcon->insert_id;
			$_SESSION['userSession']=$ID;
		}else{
			$query=$DBcon->query("SELECT  sellerID FROM seller WHERE sellerEmail='$row2[buyerEmail]'");
			$result=$query->fetch_array();
			$_SESSION['userSession']=$result['sellerID'];
		}
		header("Location:change.php?bs=s");
	}
	$DBcon->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Buyer Page</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  <?php if($bs=='b'){  ?>
            <li class="active"><a href="../change.php?bs=b">Edit Info</a></li>
            <li><a href="../search.php">Search</a></li>
            <li><a href="../cart.php">Cart</a></li>
            <li ><a href="../orderHistory.php">Order History</a></li>
		  <?php } elseif($bs=='s'){ ?>
		    <li class="active"><a href="../change.php?bs=b">Edit Info</a></li>
            <li><a href="../addStore.php">Store</a></li>
            <li><a href="../recvOrder.php">Recieve Order</a></li>
		  <?php } ?>
		  
          </ul>
		  <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;</a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<br><br></br></br>
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <h3>Personal info</h3>
        
        <form class="form-horizontal" role="form" method="post">
          
		  <?php
			if (isset($msg)) {
				echo $msg;
			}
			?>
		 
		  <div class="form-group">
			<label class="col-lg-3 control-label">User Name:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="User Name" name="name">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Phone:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Phone" name="phone">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-lg-3 control-label">Email:</label>
			<div class="col-lg-8">
			  <input class="form-control" type="text" placeholder="Email" name="email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Password:</label>
			<div class="col-md-8">
			  <input class="form-control" type="password" placeholder="Password" name="password">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Confirm password:</label>
			<div class="col-md-8">
			  <input class="form-control" type="password" placeholder="Confirm Password" name="password2">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label"></label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-save">
			  <span class="glyphicon glyphicon-save-changes"></span>Save Changes
			  </button>
			  <a href="javascript:history.back()" class="btn btn-default" style="float:right;">Cancel</a>
			</div>
		  </div>
		  
		  <?php if($bs=='b'){  ?>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Change to seller</label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-seller">
			  <span class="glyphicon glyphicon-seller-change"></span>Seller Change
			  </button>
			</div>
		  </div>
		  
		  <?php } elseif($bs=='s'){ ?>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Change to buyer</label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-buyer">
			  <span class="glyphicon glyphicon-buyer-change"></span>Buyer Change
			  </button>
			</div>
		  </div>
		  
		  <?php } ?>
		  
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>