<!--Including server.php-->
<?php 
  include('server.php');
?>

<!--Including the header -->
<?php
  error_reporting(E_ALL ^ E_NOTICE);
  $title = "Admin panel";
  include "header.php";

  include_once "functions.php";

if(isLoggedIn() and isset($_SESSION['admin'])) {} else {
    header("location: login_admin.php");
  }

$db = dbConnect();

$appointmentsQuery = "SELECT * FROM appointments";
$appointments = mysqli_query($db, $appointmentsQuery);

$consultationsQuery = "SELECT * FROM images_and_description";
$consultations = mysqli_query($db, $consultationsQuery);
?>
	
<!--Page body -->

<body class="body" style="text-align: center">


	<h1 class="body-content">Welcome to your digital admin panel</h1>
    <br />
    <!--Adding some description text on digital consultation-->
    <p class="body-content">
      Here you will find all the appointements and virtual consultations sent by your patients
    </p>
    <br />
    <br/>
    <hr/>
    <br/>
    <h1>Appointments</h1>
    <?php 
      if (mysqli_num_rows($appointments) > 0) {
    ?>
      <table style="width:100%; margin-top:15px;">
        <thead>
          <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Appointment Date</th>
            <th>Telephone</th>
          </tr>
        </thead>
        <tbody>
          <?php
            while($row = mysqli_fetch_assoc($appointments)) {
          ?>
            <tr>
              <td><?php echo $row["username"] ?></td>
              <td><?php echo $row["pname"] ?></td>
              <td><?php echo $row["surname"] ?></td>
              <td><?php echo $row["appointmentDate"] ?></td>
              <td><?php echo $row["telephone"] ?></td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
    <?php
      } else {
        echo "There is no appointment for the moment";
      }
    ?>

  <br/>
  <hr/>
  <br/>
  <h1>Consultations</h1>
  <span>Find your consultations here</span>
    <?php 
      if (mysqli_num_rows($consultations) > 0) {
    ?>
      <table style="width:100%; margin-top:15px;">
        <thead>
          <tr>
            <th>Id</th>
            <th>Patient</th>
            <th>Images</th>
            <th>Description</th>
            <th>Email</th>
            <th>Telephone</th>
          </tr>
        </thead>
        <tbody>
          <?php
            while($row = mysqli_fetch_assoc($consultations)) {
          ?>
            <tr>
              <td><?php echo $row["id"] ?></td>
              <td><?php echo $row["name"]." ".$row["surname"] ?></td>
              <td><?php
                # Displaying images
                $dirname = $row['location'];
                $files = glob($dirname."/*.*");
                for ($i=0; $i<count($files); $i++)
                  {
                    $image = $files[$i];
                    $supported_file = array(
                            'gif',
                            'jpg',
                            'jpeg',
                            'png'
                    );

                    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                    if (in_array($ext, $supported_file)) {                        
                        echo '<a href="'.$image.'" alt="'.basename($image).'"/>'.basename($image).'</a><br/>';
                        } else {
                            continue;
                        }
                      }
              ?></td>
              <td><?php echo $row["description"] ?></td>
              <td><?php echo '<a href="mailto:'.$row["email"].'">'.$row["email"].'</a>' ?></td>
              <td><?php echo $row["telephone"] ?></td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
    <?php
      } else {
        echo "There is no consultation for the moment";
      }
    ?>
  <br/>
  <hr/>
  <br/>
  <br/>
  <br/>
  <br/>
</body>

<!--Including the footer --> 
<?php
	include "footer.php";
	?>

