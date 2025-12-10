<?php

    //learn from w3schools.com

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
    

    //import database
    include("../connection.php");
    $sqlmain= "select * from student where semail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["sid"];
    $username=$userfetch["sname"];


    if($_POST){
        if(isset($_POST["booknow"])){
            $apponum=$_POST["apponum"];
            $scheduleid=$_POST["scheduleid"];
            $date=$_POST["date"];

            // Check capacity before booking
            $sql_capacity = "SELECT nop FROM schedule WHERE scheduleid = $scheduleid";
            $capacity_result = $database->query($sql_capacity);
            $capacity_row = $capacity_result->fetch_assoc();
            $max_capacity = $capacity_row['nop'];

            $sql_current = "SELECT COUNT(*) as current_count FROM appointment WHERE scheduleid = $scheduleid";
            $current_result = $database->query($sql_current);
            $current_row = $current_result->fetch_assoc();
            $current_bookings = $current_row['current_count'];

            if($current_bookings >= $max_capacity){
                // Redirect back with error message
                header("location: booking.php?id=$scheduleid&error=capacity_full");
                exit();
            }

            $sql2="insert into appointment(pid,apponum,scheduleid,appodate) values ($userid,$apponum,$scheduleid,'$date')";
            $result= $database->query($sql2);

            // Get faculty details for email
            $sql_faculty = "SELECT faculty.facemail, faculty.facname, schedule.title, schedule.scheduledate, schedule.scheduletime
                            FROM faculty
                            INNER JOIN schedule ON faculty.facid = schedule.facid
                            WHERE schedule.scheduleid = $scheduleid";
            $faculty_result = $database->query($sql_faculty);
            $faculty_email = '';
            $faculty_name = '';
            $session_title = '';
            $session_date = '';
            $session_time = '';
            if ($faculty_result && $faculty_result->num_rows > 0) {
                $faculty_data = $faculty_result->fetch_assoc();
                $faculty_email = $faculty_data['facemail'];
                $faculty_name = $faculty_data['facname'];
                $session_title = $faculty_data['title'];
                $session_date = $faculty_data['scheduledate'];
                $session_time = $faculty_data['scheduletime'];
            }

            // Output HTML page with EmailJS
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Complete</title>
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
                <div id="emailStatus">Processing booking and sending notification...</div>
                <script>
                  const templateParams = {
                    to_email: <?php echo json_encode($faculty_email); ?>,
                    faculty_name: <?php echo json_encode($faculty_name); ?>,
                    student_name: <?php echo json_encode($username); ?>,
                    appointment_number: <?php echo json_encode($apponum); ?>,
                    session_title: <?php echo json_encode($session_title); ?>,
                    session_date: <?php echo json_encode($session_date); ?>,
                    session_time: <?php echo json_encode($session_time); ?>
                  };

                  function sendBookingEmail() {
                    const SERVICE_ID = "service_7azhp5s";   // Your service ID
                    const TEMPLATE_ID = "template_byh3r2c"; // Your template ID

                    emailjs.send(SERVICE_ID, TEMPLATE_ID, templateParams)
                      .then(function(response) {
                         console.log('SUCCESS!', response.status, response.text);
                         document.getElementById('emailStatus').innerText = "Faculty notified successfully! Redirecting...";
                         setTimeout(() => {
                           window.location.href = 'appointment.php?action=booking-added&id=<?php echo $apponum; ?>&titleget=none';
                         }, 2000);
                      }, function(error) {
                         console.error('FAILED...', error);
                         document.getElementById('emailStatus').innerText = "Booking completed, but failed to notify faculty. Redirecting...";
                         setTimeout(() => {
                           window.location.href = 'appointment.php?action=booking-added&id=<?php echo $apponum; ?>&titleget=none';
                         }, 2000);
                      });
                  }

                  // Trigger sending when page loads
                  document.addEventListener('DOMContentLoaded', sendBookingEmail);
                </script>
            </body>
            </html>
            <?php
            exit();

        }
    }
 ?>