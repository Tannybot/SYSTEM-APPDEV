<?php

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='s'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }
}else{
    header("location: ../login.php");
}

include("../connection.php");

if($_POST){
    $appoid = $_POST['appoid'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    if(empty($rating)){
        header("location: appointment.php?review=error&msg=Rating is required");
        exit;
    }

    // Get student id
    $sqlmain= "select * from student where semail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $sid= $userfetch["sid"];

    // Get faculty id from appointment
    $appt = $database->query("SELECT schedule.facid FROM appointment INNER JOIN schedule ON appointment.scheduleid=schedule.scheduleid WHERE appoid='$appoid'");
    $appt_fetch = $appt->fetch_assoc();
    $facid = $appt_fetch['facid'];

    // Check if review already exists
    $check = $database->query("SELECT * FROM reviews WHERE appoid='$appoid' AND reviewer_type='student' AND reviewer_id='$sid'");
    if($check->num_rows > 0){
        header("location: appointment.php?review=error&msg=Review already submitted");
        exit;
    }

    // Insert review
    $sql = "INSERT INTO reviews (appoid, reviewer_type, reviewer_id, reviewee_id, rating, comments) VALUES ('$appoid', 'student', '$sid', '$facid', '$rating', '$comments')";
    if($database->query($sql)){
        header("location: appointment.php?review=success");
    }else{
        header("location: appointment.php?review=error");
    }
}
?>