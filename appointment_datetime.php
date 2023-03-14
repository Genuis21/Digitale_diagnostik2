<?php

include_once "functions.php";

// connect to the database
$db = dbConnect();

// Retrieve the chosen dates from the database
$query = "SELECT appointmentDate FROM appointments";
$result = mysqli_query($db, $query);
$chosenDates = array();
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $chosenDates[] = $row['appointmentDate'];
    }
}

// Return the chosen dates as a JSON array
echo json_encode($chosenDates);

mysqli_close($db);
?>