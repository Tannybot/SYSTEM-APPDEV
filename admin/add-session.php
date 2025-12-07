<?php

    session_start();
    
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
        //import database
        include("../connection.php");
        $title=$_POST["title"];
        $docid=$_POST["docid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        $sql="insert into schedule (facid,title,scheduledate,scheduletime,nop) values ($docid,'$title','$date','$time',$nop);";
        $result= $database->query($sql);

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
            <title>Session Added</title>
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
            <div id="emailStatus">Session added successfully. Notifying faculty...</div>
            <script>
              const templateParams = {
                to_email: <?php echo json_encode($faculty_email); ?>,
                faculty_name: <?php echo json_encode($faculty_name); ?>,
                session_title: <?php echo json_encode($title); ?>,
                session_date: <?php echo json_encode($date); ?>,
                session_time: <?php echo json_encode($time); ?>,
                action: "added"
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
                     document.getElementById('emailStatus').innerText = "Session added, but failed to notify faculty. Redirecting...";
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
        
   // } 


?>