<!--Including server.php-->
<?php include('server.php') ?>

<!--Including the header -->
<?php
  error_reporting(E_ALL ^ E_NOTICE);
  $title = "Admin panel";
  include "header.php";
?>
	
<!--Page body -->

<body class="body">


	<h1 class="body-content">Welcome to your digital admin panel</h1>
    <br />
    <!--Adding some description text on digital consultation-->
    <p class="body-content">
      Here you will find all the appointements and virtual consultations sent by your patients
    </p>

      <!--Loggin in as admin User -->
    <div class="header">
      <h2>Admin Login</h2>
    </div>
    
    <form method="post" action="login.php">
      <?php include('errors.php'); ?>
      <div class="input-group">
        <label>Username</label>
        <input required type="text" name="username" >
      </div>
      <div class="input-group">
        <label>Password</label>
        <input required type="password" name="password">
      </div>
      <div class="input-group">
        <button type="submit" class="btn" name="login_admin">Login</button>
      </div>
      <p>
        Not yet a member? <a href="register.php">Sign up</a>
      </p>
    </form>
    <br />
    <br />
</body>

<!--Including the footer --> 
<?php
	include "footer.php";
	?>

