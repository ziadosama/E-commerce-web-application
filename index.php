<?php
session_start();
require_once 'dbconnect.php';

if (isset($_SESSION['userSession'])!="") {
	header("Location: home.php");
	exit;
}

if (isset($_POST['btn-login'])) {
	
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	$bs = strip_tags($_POST['bs']);

	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);
	$bs = $DBcon->real_escape_string($bs);
	
	if($bs=="b"){
		$query = $DBcon->query("SELECT buyerID, buyerEmail, buyerPwd FROM buyer WHERE buyerEmail='$email'");
		$row=$query->fetch_array();
		$count = $query->num_rows; // if email/password are correct returns must be 1 row
		
		if (password_verify($password, $row['buyerPwd']) && $count==1) {
			$_SESSION['userSession'] = $row['buyerID'];
			header("Location: buye.php");
			echo "1";
		} else {
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
				</div>";
		}
	}
	elseif($bs=="s"){

		$query = $DBcon->query("SELECT sellerID, sellerEmail, sellerPwd FROM seller WHERE sellerEmail='$email'");
		$row=$query->fetch_array();
		$count = $query->num_rows; // if email/password are correct returns must be 1 row
		
		if (password_verify($password, $row['sellerPwd']) && $count==1) {
			$_SESSION['userSession'] = $row['sellerID'];
			header("Location: seller.php");
		}
		else {
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
				</div>";
		}
	}
	else{
			$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid buyer or seller !
				</div>";
	}
	
	
	$DBcon->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<style type="text/css">
#background {
    width: 100%; 
    height: 100%; 
    position: fixed; 
    left: 0px; 
    top: 0px; 
    z-index: -1; /* Ensure div tag stays behind content; -999 might work, too. */
}

.stretch {
    width:100%;
    height:100%;
}
</style>
<div id="background">
    <img src="bg.JPG" class="stretch" alt="" />
</div>
<div class="signin-form">

	<div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Sign In.</h2><hr />
        
        <?php
		if(isset($msg)){
			echo $msg;
		}
		?>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required />
        </div>
		
		<div class="form-group">
        <input type="text" class="form-control" placeholder="b for buyer or s for seller" name="bs" required />
        </div>
       
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
			</button> 
            
            <a href="register.php" class="btn btn-default" style="float:right;">Sign UP Here</a>
            
        </div>  
        
        
      
      </form>

    </div>
    
</div>

</body>
</html>