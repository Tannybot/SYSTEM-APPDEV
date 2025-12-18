<?php

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='f'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }
}else{
    header("location: ../login.php");
}

include("../connection.php");
include("../notification_functions.php");

if($_POST){
    $appoid = $_POST['appoid'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    if(empty($rating)){
        header("location: appointment.php?review=error&msg=Rating is required");
        exit;
    }

    // Get faculty id and name
    $userrow = $database->query("select * from faculty where facemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $facid= $userfetch["facid"];
    $faculty_name = $userfetch["facname"];

    // Get student id from appointment
    $appt = $database->query("SELECT pid FROM appointment WHERE appoid='$appoid'");
    $appt_fetch = $appt->fetch_assoc();
    $sid = $appt_fetch['pid'];

    // Get student email
    $student_query = $database->query("SELECT semail, sname FROM student WHERE sid='$sid'");
    $student_fetch = $student_query->fetch_assoc();
    $student_email = $student_fetch['semail'];
    $student_name = $student_fetch['sname'];

    // Check if review already exists
    $check = $database->query("SELECT * FROM reviews WHERE appoid='$appoid' AND reviewer_type='faculty' AND reviewer_id='$facid'");
    if($check->num_rows > 0){
        header("location: appointment.php?review=error&msg=Review already submitted");
        exit;
    }

    // Insert review
    $sql = "INSERT INTO reviews (appoid, reviewer_type, reviewer_id, reviewee_id, rating, comments) VALUES ('$appoid', 'faculty', '$facid', '$sid', '$rating', '$comments')";
    if($database->query($sql)){
        // Add notification to student with review details
        $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
        $message = "Faculty $faculty_name has left remarks on your appointment: Rating: $stars" . (!empty($comments) ? " | Comments: $comments" : "");
        add_notification($student_email, 'review', $message);
        header("location: appointment.php?review=success");
    }else{
        header("location: appointment.php?review=error");
    }
}
?>