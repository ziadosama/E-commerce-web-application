<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: home.php");
}
require_once 'dbconnect.php';

if(isset($_POST['btn-signup'])) {
	
	$uname = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
	$bs = strip_tags($_POST['bs']);
	$phone = strip_tags($_POST['phone']);
	
	
	$uname = $DBcon->real_escape_string($uname);
	$email = $DBcon->real_escape_string($email);
	$upass = $DBcon->real_escape_string($upass);
	$bs = $DBcon->real_escape_string($bs);
	$phone = $DBcon->real_escape_string($phone);
	
	$hashed_password = password_hash($upass, PASSWORD_DEFAULT);
	
	if($bs=="b")
	{
		$check_email = $DBcon->query("SELECT buyerEmail FROM buyer WHERE buyerEmail='$email'");
		$count=$check_email->num_rows;
		if($count==0){
			$query = "INSERT INTO buyer(buyerPhone,buyerName,buyerEmail,buyerPwd) VALUES('$phone','$uname','$email','$hashed_password')";
			if ($DBcon->query($query)) {
				$msg = "<div class='alert alert-success'>
							<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
						</div>";
			}else {
				$msg = "<div class='alert alert-danger'>
							<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
						</div>";
			}
		}
		else{
			$msg = "<div class='alert alert-danger'>
							<span class='glyphicon glyphicon-info-sign'></span> &nbsp; email already exists !
						</div>";
		}
	}elseif($bs=="s") {
		$check_email = $DBcon->query("SELECT sellerEmail FROM seller WHERE sellerEmail='$email'");
		$count=$check_email->num_rows;
		if($count==0){
			$query = "INSERT INTO seller(sellerPhone,sellerName,sellerEmail,sellerPwd) VALUES('$phone','$uname','$email','$hashed_password')";
			if ($DBcon->query($query)) {
			$msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					</div>";
			}
			else{
				$msg = "<div class='alert alert-danger'>
							<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
						</div>";
			}
		}else {
			$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; email already exists !
					</div>";
		}
	}
	$DBcon->close();
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
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
     
        
       <form class="form-signin" method="post" id="register-form">
      
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        
        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="username" required  />
        </div>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required  />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required  />
        </div>
		
		<div class="form-group">
        <input type="phone" class="form-control" placeholder="Phone" name="phone" required  />
        </div>
        
		<div class="form-group">
        <input type="text" class="form-control" placeholder="b for buyer or s for seller" name="bs" required  />
        </div>
		
     	<hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
			</button> 
            <a href="index.php" class="btn btn-default" style="float:right;">Log In Here</a>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>