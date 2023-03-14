<!--Including the header -->
<?php
  $title = "Online appointment";
  include "header.php";
  include_once "functions.php";

  if(!isLoggedIn()) {
    header("location: login.php");
  }
?>
	
<!--Page body -->
  <body id="body">
    <h2 class="body-content">Online appointment</h2>
    <p class="body-content">
      Get an appointment on a date, which best suits you. Make sure to
      subsequently appear atleast 15 minutes before your appointment<br />
      If you can&apos;t take the appointment on the specified date, kindly
      cancel it.

      <div>
        <form class="appointment-form" method="post" action="server.php">
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
            <label>Username*</label>
            <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" required>
          </div>
          <?php # include('errors.php'); ?>
          <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" value="<?php # echo $name; ?>">
          </div>
          <div class="input-group">
            <label>Surname</label>
            <input type="text" name="surname" value="<?php # echo $surname; ?>">
          </div>
          <div class="input-group">
            <label>Telephone*</label>
            <input type="number" name="telephone" required>
          </div>          
          <div class="input-group">
            <label>Date*</label>
            <input type="datetime-local" name="date" required>
          </div>
          <div class="input-group">
            <button type="submit" class="btn" name="appointment">Submit</button>
          </div>
        </form>
      </div>
    </p>
  </body>
<!--Including the footer --> 
<?php
	include "footer.php";
?>

<script>
fetch('appointment_datetime.php')
  .then(response => response.json())
  .then(chosenDates => {
    var dateControl = document.querySelector('input[type="datetime-local"]');
    dateControl.min = new Date().toJSON().slice(0,16);
    dateControl.addEventListener('focus', function() {
        var value = this.value;
        this.value = value;
    }, false);
    dateControl.addEventListener('blur', function() {
        var value = this.value;
        this.type = "datetime-local";
        this.value = value;
    }, false);
    dateControl.addEventListener('change', function() {
        var selectedDate = new Date(this.value);
        var day = selectedDate.getUTCDay();
        var hour = selectedDate.getHours();
        var selectedDateFormatted = selectedDate.getFullYear().toString().padStart(2, '0') + "-" + (selectedDate.getMonth() + 1).toString().padStart(2, '0') + "-" + selectedDate.getDate().toString().padStart(2, '0') + " " + selectedDate.getHours().toString().padStart(2, '0') + ":" + selectedDate.getMinutes().toString().padStart(2, '0') + ":" + selectedDate.getSeconds().toString().padStart(2, '0');
        if (chosenDates.includes(selectedDateFormatted)) {
          alert("This date and time has already been chosen, please select another date and time. Selected date and times are " + JSON.stringify(chosenDates));
          this.value = "";
        } else if (day === 0 || day === 6) {
          alert("Weekend dates are not allowed, please select another date.");
          this.value = "";
        } else if(hour < 8 || hour > 14) {
          alert("Please choose a time between 8am and 2pm.");
          this.value = "";
        }
    });
});
</script>