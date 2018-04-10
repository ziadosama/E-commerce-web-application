<?php
	session_start();
	include_once 'dbconnect.php';

	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}
	
	
	if (isset($_POST['btn-save'])) {
		
	
	$DBcon->close();
	}

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
    <h1>Edit Profile</h1>
  	<hr>
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
			  <span class="glyphicon glyphicon-save-changes"></span> &nbsp; Save Changes
			  </button>
			  <a href="buye.php" class="btn btn-default" style="float:right;">Cancel</a>
			</div>
		  </div>
		  
		  <?php if($bs=='b'){  ?>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Change to seller</label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-seller">
			  <span class="glyphicon glyphicon-seller-change"></span> &nbsp; Seller Change
			  </button>
			</div>
		  </div>
		  
		  <?php } elseif($bs=='s'){ ?>
		  
		  <div class="form-group">
			<label class="col-md-3 control-label">Change to buyer</label>
			<div class="col-md-8">
			  <button type="submit" class="btn btn-default" name="btn-buyer">
			  <span class="glyphicon glyphicon-buyer-change"></span> &nbsp; Buyer Change
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