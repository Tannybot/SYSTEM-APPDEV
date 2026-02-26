<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
            exit();
        }

    }else{
        header("location: ../login.php");
            exit();
    }
    
    
    if($_GET){
        //import database
        include("../connection.php");
        $id=$_GET["id"];

        // Get appointment details before deletion
        $sql_details = "SELECT appointment.appoid, appointment.apponum, student.semail, student.sname, faculty.facemail, faculty.facname, schedule.title, schedule.scheduledate, schedule.scheduletime
                        FROM appointment
                        INNER JOIN student ON appointment.pid = student.sid
                        INNER JOIN schedule ON appointment.scheduleid = schedule.scheduleid
                        INNER JOIN faculty ON schedule.facid = faculty.facid
                        WHERE appointment.appoid='$id'";
        $details_result = $database->query($sql_details);
        $student_email = '';
        $student_name = '';
        $faculty_email = '';
        $faculty_name = '';
        $session_title = '';
        $session_date = '';
        $session_time = '';
        $apponum = '';
        if ($details_result && $details_result->num_rows > 0) {
            $details = $details_result->fetch_assoc();
            $student_email = $details['semail'];
            $student_name = $details['sname'];
            $faculty_email = $details['facemail'];
            $faculty_name = $details['facname'];
            $session_title = $details['title'];
            $session_date = $details['scheduledate'];
            $session_time = $details['scheduletime'];
            $apponum = $details['apponum'];
        }

        // Delete the appointment
        $sql= $database->query("delete from appointment where appoid='$id';");

        // Output HTML page with EmailJS for notifications
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Appointment Canceled</title>
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
            <div id="emailStatus">Canceling appointment and sending notifications...</div>
            <script>
              // Send email to student
              const studentParams = {
                to_email: <?php echo json_encode($student_email); ?>,
                recipient_name: <?php echo json_encode($student_name); ?>,
                appointment_number: <?php echo json_encode($apponum); ?>,
                session_title: <?php echo json_encode($session_title); ?>,
                session_date: <?php echo json_encode($session_date); ?>,
                session_time: <?php echo json_encode($session_time); ?>,
                action: "canceled"
              };

              // Send email to faculty
              const facultyParams = {
                to_email: <?php echo json_encode($faculty_email); ?>,
                recipient_name: <?php echo json_encode($faculty_name); ?>,
                appointment_number: <?php echo json_encode($apponum); ?>,
                session_title: <?php echo json_encode($session_title); ?>,
                session_date: <?php echo json_encode($session_date); ?>,
                session_time: <?php echo json_encode($session_time); ?>,
                action: "canceled"
              };

              function sendNotifications() {
                const SERVICE_ID = "service_7azhp5s";
                const TEMPLATE_ID = "template_byh3r2c"; // Assuming same template, or create separate

                // Send to student
                emailjs.send(SERVICE_ID, TEMPLATE_ID, studentParams)
                  .then(function(response) {
                     console.log('Student notification sent!', response.status, response.text);
                     // Send to faculty
                     return emailjs.send(SERVICE_ID, TEMPLATE_ID, facultyParams);
                  })
                  .then(function(response) {
                     console.log('Faculty notification sent!', response.status, response.text);
                     document.getElementById('emailStatus').innerText = "Appointment canceled and notifications sent. Redirecting...";
                     setTimeout(() => {
                       window.location.href = 'appointment.php';
                     }, 2000);
                  })
                  .catch(function(error) {
                     console.error('Failed to send notifications:', error);
                     document.getElementById('emailStatus').innerText = "Appointment canceled. Failed to send some notifications. Redirecting...";
                     setTimeout(() => {
                       window.location.href = 'appointment.php';
                     }, 2000);
                  });
              }

              // Trigger sending when page loads
              document.addEventListener('DOMContentLoaded', sendNotifications);
            </script>
        </body>
        </html>
        <?php
        exit();
    }


?>