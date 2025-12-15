<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='s'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }


        //import database
        include("../connection.php");
        $userrow = $database->query("select * from student where semail='$useremail'");
        $userfetch = $userrow->fetch_assoc();
        $userid = $userfetch["sid"];

        $title=$_POST["title"];
        $docid=$_POST["docid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];

        // Basic validations
        $today = date('Y-m-d');
        if($date < $today){
            echo "<script>alert('Cannot schedule sessions in the past.'); window.location.href='schedule.php';</script>";
            exit();
        }

        // Check for conflicts: same faculty, same date and time
        $sql_check = "SELECT * FROM schedule WHERE facid=$docid AND scheduledate='$date' AND scheduletime='$time'";
        $check_result = $database->query($sql_check);
        if($check_result->num_rows > 0){
            echo "<script>alert('This faculty already has a session at this date and time. Please choose a different time.'); window.location.href='schedule.php';</script>";
            exit();
        }

        // Check faculty availability
        $day_of_week = date('N', strtotime($date)); // 1=Monday, 7=Sunday
        $sql_avail = "SELECT * FROM faculty_availability WHERE facid=$docid AND day_of_week=$day_of_week AND start_time <= '$time' AND end_time >= '$time'";
        $avail_result = $database->query($sql_avail);
        if($avail_result->num_rows == 0){
            header("location: schedule.php?action=add-session&error=availability");
            exit();
        }

        $sql="insert into schedule (facid,title,scheduledate,scheduletime,nop) values ($docid,'$title','$date','$time',$nop);";
        $result= $database->query($sql);

        // Get the inserted scheduleid
        $scheduleid = $database->insert_id;

        // Automatically book the student into this session
        $today = date('Y-m-d');
        $sql_appointment = "INSERT INTO appointment (pid, apponum, scheduleid, appodate) VALUES ($userid, 1, $scheduleid, '$today')";
        $database->query($sql_appointment);

        // Get faculty details for notification
        $sql_faculty = "SELECT facemail, facname FROM faculty WHERE facid=$docid";
        $faculty_result = $database->query($sql_faculty);
        $faculty_email = '';
        $faculty_name = '';
        if ($faculty_result && $faculty_result->num_rows > 0) {
            $faculty_data = $faculty_result->fetch_assoc();
            $faculty_email = $faculty_data['facemail'];
            $faculty_name = $faculty_data['facname'];
        }

        // Output HTML page with EmailJS
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Session Scheduled</title>
            <!-- Include EmailJS SDK -->
            <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
            <script>
              // Initialize EmailJS with your public key
              (function(){
                emailjs.init("EYRzDBvMug50hIlHV");
              })();
            </script>
        </head>
        <body>
            <div id="emailStatus">Session scheduled successfully. Notifying faculty...</div>
            <script>
              const templateParams = {
                to_email: <?php echo json_encode($faculty_email); ?>,
                faculty_name: <?php echo json_encode($faculty_name); ?>,
                session_title: <?php echo json_encode($title); ?>,
                session_date: <?php echo json_encode($date); ?>,
                session_time: <?php echo json_encode($time); ?>,
                action: "scheduled"
              };

              function sendNotification() {
                const SERVICE_ID = "service_7azhp5s";
                const TEMPLATE_ID = "template_byh3r2c";

                emailjs.send(SERVICE_ID, TEMPLATE_ID, templateParams)
                  .then(function(response) {
                     console.log('Faculty notification sent!', response.status, response.text);
                     document.getElementById('emailStatus').innerText = "Faculty notified successfully! Redirecting...";
                     setTimeout(() => {
                       window.location.href = 'schedule.php?action=session-added&title=<?php echo urlencode($title); ?>';
                     }, 2000);
                  }, function(error) {
                     console.error('Failed to send notification:', error);
                     document.getElementById('emailStatus').innerText = "Session scheduled, but failed to notify faculty. Redirecting...";
                     setTimeout(() => {
                       window.location.href = 'schedule.php?action=session-added&title=<?php echo urlencode($title); ?>';
                     }, 2000);
                  });
              }

              // Trigger sending when page loads
              document.addEventListener('DOMContentLoaded', sendNotification);
            </script>
        </body>
        </html>
        <?php
        exit();


?>