<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='f'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }


    if($_GET){
        //import database
        include("../connection.php");
        include("../notification_functions.php");
        $id=$_GET["id"];
        $sql= $database->query("UPDATE appointment SET status='done' WHERE appoid='$id'");

        // Get student email and appointment details
        $appt = $database->query("SELECT pid FROM appointment WHERE appoid='$id'");
        $appt_fetch = $appt->fetch_assoc();
        $sid = $appt_fetch['pid'];
        $student_query = $database->query("SELECT semail, sname FROM student WHERE sid='$sid'");
        $student_fetch = $student_query->fetch_assoc();
        $student_email = $student_fetch['semail'];
        $student_name = $student_fetch['sname'];

        // Get session title
        $session_query = $database->query("SELECT schedule.title FROM appointment INNER JOIN schedule ON appointment.scheduleid = schedule.scheduleid WHERE appointment.appoid='$id'");
        $session_fetch = $session_query->fetch_assoc();
        $session_title = $session_fetch['title'];

        // Add notification to student
        $message = "Your appointment for '$session_title' has been marked as done by the faculty.";
        add_notification($student_email, 'appointment_done', $message);

        header("location: appointment.php?action=review&id=$id");
    }


?>