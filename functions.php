<?php
    // Defining function
    function isLoggedIn() {
        return isset($_SESSION['username']) and !empty($_SESSION['username']);
    }

    function dbConnect() {
        // connect to the database
        $db = mysqli_connect('localhost', 'root', '', 'project_login');

        //Checking connection to database
        if ($db->connect_error){
        die("connection failed: " . $db->connect_error);
        }

        return $db;
    }
?>