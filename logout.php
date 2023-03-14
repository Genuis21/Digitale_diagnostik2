<!--Including the header -->
<?php
	$title = "Logout";
	include "header.php";

	session_destroy();
?>
	
<!--Page body -->

<body id="body">
    <h2 class="body-content">You have been succesfully logged-out!</h2>
  </body>

<!--Including the footer --> 
<?php
	include "footer.php";

	header("location: index.php")
?>