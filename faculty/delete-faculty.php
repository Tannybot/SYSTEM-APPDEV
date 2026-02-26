<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='f'){
            header("location: ../login.php");
            exit();
        }else{
            $useremail = $_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
            exit();
    }


    if($_GET){
        //import database
        include("../connection.php");
        $id = $_GET["id"];

        // Get faculty email
        $result001 = $database->query("select * from faculty where facid=$id;");
        if($result001->num_rows == 0){
            header("location: settings.php?error=notfound");
            exit();
        }
        $facdata = $result001->fetch_assoc();
        $email = $facdata["facemail"];

        // Check if it's the logged-in user
        if($email != $useremail){
            header("location: settings.php?error=unauthorized");
            exit();
        }

        // Delete appointments for this faculty's schedules
        $sql = $database->query("DELETE FROM appointment WHERE scheduleid IN (SELECT scheduleid FROM schedule WHERE facid=$id);");
        // Delete schedules
        $sql = $database->query("DELETE FROM schedule WHERE facid=$id;");
        // Delete from webuser
        $sql = $database->query("delete from webuser where email='$email';");
        // Delete from faculty
        $sql = $database->query("delete from faculty where facemail='$email';");

        // Redirect to logout
        header("location: ../logout.php");
    }

?>