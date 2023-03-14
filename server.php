<?php
session_start();

include_once "functions.php";

// initializing variables
$username = "";
$email    = "";
$errors = array();
/*
$username = "localhost";
$username = "root";
$password = "root";
$dbName = "uploaded_patient_images";
*/

// connect to the database
$db = dbConnect();

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	} else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

// LOGIN ADMIN
if (isset($_POST['login_admin'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  $password = md5($password);
  $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND is_admin='1'";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results) == 1) {
    $_SESSION['username'] = $username;
    $_SESSION['admin'] = 1;
    $_SESSION['success'] = "You are now logged in";
    header('location: admin.php?success="You have been successfully logged in as Admin user');
  } else {
    header('location: login_admin.php?error="An error occured. Please check your username or password"');
  }
}

// MAKE APPOINTMENT
if(isset($_POST['appointment'])) {

  if(!isLoggedIn()) {
    header('location: login.php.php');
  } else {
    // receive all input values from the form
    $telephone = trim(mysqli_real_escape_string($db, $_POST['telephone']));
    $username = trim(mysqli_real_escape_string($db, $_POST['username']));
    $appointmentDate = trim(mysqli_real_escape_string($db, $_POST['date']));
    $name = trim(mysqli_real_escape_string($db, $_POST['name']));
    $surname = trim(mysqli_real_escape_string($db, $_POST['surname']));

    // first check the database to make sure the appointment has not been registered under this phone number
    $appointment_check_query = "SELECT * FROM appointments WHERE telephone='$telephone' LIMIT 1";
    $appointment = mysqli_fetch_assoc(mysqli_query($db, $appointment_check_query));
    
    if ($appointment) { // if an appointment with this phone number exists
      header('location: online-appointment.php?error=An appointment under this phone number already exists');
    } else {
      // Add appointment in the database
      $query = "INSERT INTO appointments (telephone, username, appointmentDate, pname, surname) VALUES('$telephone', '$username', '$appointmentDate', '$name', '$surname')";
      if($result = mysqli_query($db, $query)) {
        header('location: online-appointment.php?success=The Appointment has been registered');
      } else {
        header('location: online-appointment.php?error=An error occured. The Appointment could not be registered');
      }
    }
  }
}

//Storing/Uploading images and descriiption to database
if(isset($_POST['v_consult'])) {

  if(!isLoggedIn()) {
    header('location: login.php');
  } else {
    // receive all input values from the form
    $description = trim(mysqli_real_escape_string($db, $_POST['description']));
    $name = trim(mysqli_real_escape_string($db, $_POST['name']));
    $surname = trim(mysqli_real_escape_string($db, $_POST['surname']));
    $email = trim(mysqli_real_escape_string($db, $_POST['email']));
    $telephone = trim(mysqli_real_escape_string($db, $_POST['telephone']));

    $id = $_SESSION['username'].time();
    $username = $_SESSION['username'];
    $dir = 'consultation/'.$id;

    mkdir($dir);

    // Start file upload
    $error=array();
    $extension=array("jpeg","jpg","png","gif");
    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
      $file_name=$_FILES["files"]["name"][$key];
      $file_tmp=$_FILES["files"]["tmp_name"][$key];
      $ext=pathinfo($file_name,PATHINFO_EXTENSION);

      if(in_array($ext, $extension)) {
          if(!file_exists($dir."/".$file_name)) {
              move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],$dir."/".$file_name);
          }
          else {
              $filename=basename($file_name,$ext);
              $newFileName=$filename.time().".".$ext;
              move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],$dir."/".$newFileName);
          }
          header('location: virtual_consultation.php?success=The documents have been uploaded correctly');
      }
      else {
          array_push($error,"$file_name, ");
          header('location: virtual_consultation.php?error=An error occured while uploading, please try again later');
      }
    }

    // Add consultation in the database
    $query = "INSERT INTO images_and_description (id, location, description, username, name, surname, email, telephone) VALUES('$id', '$dir', '$description', '$username', '$name', '$surname', '$email', '$telephone')";
    if($result = mysqli_query($db, $query)) {
      header('location: virtual_consultation.php?success=The consultation has been received');
    } else {
      header('location: virtual_consultation.php?error=An error occured. The consultation could not be received');
    }
  }
}

mysqli_close($db);
?>