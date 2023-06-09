<!--Including server.php-->
<?php include('server.php') ?>

<!--Including the header -->
<?php

	error_reporting(E_ALL ^ E_NOTICE);
	$title = "login";
	include "header.php";
?>
	
<!--Page body -->

<body class="body">

  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>

<!--Including the footer --> 
<?php
	include "footer.php";
	?>