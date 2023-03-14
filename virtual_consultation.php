<!--Adding header-->
<?php
		$title = "Virtual appointment";
		include "header.php";

    if(!isLoggedIn()) {
      header("location: login.php");
    }
		?>

<!--Adding body-->
  <body class="body">
  <h1 class="body-content">Digital consultation</h1>

  <p>
    <ul class="body-content-digital">
      <li>Do you need urgent consultation?</li>
      <li>You could not get an appointment in the near future?</li>
      <li>You can&apos;t displace yourself to the physician?</li>
    </ul>
    <p class="body-content-digital">Upload a picture of your skin, showing clearly the affected parts. Add an accurate description of your pain.
       The Physician will get back to you as soon as possible with a prescription. Trust the process!
    </p>
    <!--Uploading a picture-->
    <p class="body-content-digital">Click on the "Choose Files" button to upload a picture and add a description:</p><br/><br/>

    <form action="server.php" method="post" enctype="multipart/form-data" class="uploadfiles">
      <!--<label for="file">Choose file to upload</label> &nbsp;&nbsp;&nbsp;-->
      <div class="input-group">
        <label style="text-align: center">
          <?php
            if(isset($_GET['success'])) {
              echo $_GET['success'];
            } else if(isset($_GET['error'])) {
              echo $_GET["error"];
            }
          ?>
        </label>
      </div>

      <div class="input-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name"><br/>
      </div>

      <div class="input-group">
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname"><br/>
      </div>

      <div class="input-group">
        <label for="email">E-mail*</label>
        <input type="email" id="email" name="email" required><br/>
      </div>

      <div class="input-group">
        <label for="telephone">Telephone*</label>
        <input type="number" id="telephone" name="telephone" required><br/><br/>
      </div>

      <div class="input-group">
        <label for="myFile">Images</label>
        <input type="file" id="myFile" accept="image/*" name="files[]"  style="border:none" multiple><br/>
      </div>

      <div class="input-group">
        <label for="disease_description">Description</label>
        <textarea type="text" id="disease_description" name="description" rows="8" cols="50" placeholder="Describe your disease/complain here" style="width:100%"></textarea><br/><br/>
      </div>

      <div class="input-group">
        <input type="submit" value="Send" class="buttonsend" name="v_consult" style="width:100%">
      </div>

      <!--<button class="buttonsend">Send picture</button> -->
    </form>
  </p>
</body>

<!--Adding footer-->
<?php
	include "footer.php";
	?>

