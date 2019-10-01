<?php
session_start();
if(!empty($_SESSION) && !empty($_SESSION['user'] )){
	header('Location:https://soopla.com/admin/index.php ');
} 
if($_SERVER['REQUEST_METHOD']=="POST"){
	if(isset($_POST['email']) && isset($_POST['password']) && $_POST['password'] != "" && $_POST['email'] != ""){
		$result = file_get_contents('https://soopla.com/api/Users?filter='.urlencode('{"where":{"email":"'.$_POST['email'].'","password":"'.$_POST['password'].'","spam":-1}}'));
		$result = json_decode($result,true);
		if(count($result)>0){
			session_start();
			$_SESSION['user'] = $result[0];
			header('Location:https://soopla.com/admin/index.php ');
		}else{
			$err ="Invalid Credential";
		}
			
	}else{
		$err ="Invalid email & password";
	}
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>iDesign Dash</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!--js-->
<script src="js/jquery-2.1.1.min.js"></script> 
<!--icons-css-->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet' type='text/css'>
<!--static chart-->
</head>
<body>	
<div class="login-page">
    <div class="login-main">  	
    	 <div class="login-head">
				<h1>Login</h1>
			</div>
			<div class="login-block">
				<form action="login.php" method="POST">
					<input type="text" name="email" placeholder="Email" required="">
					<input type="password" name="password" class="lock" placeholder="Password" required="">
					<button  type="submit">Login</button>
				</form>
			</div>
      </div>
</div>
<!--inner block end here-->
<!--copy rights start here-->
<div class="copyrights">
	 <p>© 2019 iDesign. All Rights Reserved</p>
</div>	
<!--COPY rights end here-->

<!--scrolling js-->
		<script src="js/jquery.nicescroll.js"></script>
		<!--//scrolling js-->
<script src="js/bootstrap.js"> </script>
<!-- mother grid end here-->
</body>
</html>


                      
						
