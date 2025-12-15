<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Appointments</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .calendar {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .calendar caption {
            background-color: #007bff;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .calendar th, .calendar td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .calendar th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
        }
        .calendar .day {
            cursor: pointer;
            position: relative;
        }
        .calendar .day:hover {
            background-color: #f1f3f4;
        }
        .calendar .has-session {
            background-color: #fff3e0;
            color: #f57c00;
            font-weight: bold;
        }
        .calendar .has-session:hover {
            background-color: #ffe0b2;
        }
        .calendar .has-appointment {
            background-color: #e3f2fd;
            color: #1976d2;
            font-weight: bold;
        }
        .calendar .has-appointment:hover {
            background-color: #bbdefb;
            transform: scale(1.05);
        }
        .calendar .has-session.has-appointment {
            background: linear-gradient(45deg, #fff3e0 50%, #e3f2fd 50%);
            color: #333;
        }
        .calendar .has-session.has-appointment:hover {
            background: linear-gradient(45deg, #ffe0b2 50%, #bbdefb 50%);
        }
        .calendar .day small {
            display: block;
            font-size: 10px;
            margin-top: 5px;
        }
        .calendar .has-session small {
            color: #f57c00;
        }
        .calendar .has-appointment small {
            color: #42a5f5;
        }
        .appointment-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 30px;
            z-index: 1000;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .appointment-popup h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .appointment-popup .close {
            float: right;
            cursor: pointer;
            font-size: 24px;
            color: #999;
            transition: color 0.3s;
        }
        .appointment-popup .close:hover {
            color: #333;
        }
        .appointment-popup div {
            margin: 10px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .appointment-popup a {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
        .appointment-popup a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php

    //learn from w3schools.com

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
    
    

       //import database
       include("../connection.php");
       $userrow = $database->query("select * from faculty where facemail='$useremail'");
       $userfetch=$userrow->fetch_assoc();
       $userid= $userfetch["facid"];
       $username=$userfetch["facname"];

       // Fetch all schedules for the faculty
       $schedules = [];
       $sql_sched = "SELECT scheduleid, title, scheduledate, scheduletime FROM schedule WHERE facid=$userid ORDER BY scheduledate, scheduletime";
       $result_sched = $database->query($sql_sched);
       while($row = $result_sched->fetch_assoc()){
           $date = $row['scheduledate'];
           if(!isset($schedules[$date])) $schedules[$date] = [];
           $schedules[$date][] = $row;
       }

       // Fetch appointments grouped by date
       $appointments = [];
       $sql = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, student.sname, schedule.scheduledate, schedule.scheduletime, appointment.apponum, appointment.appodate FROM schedule INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid INNER JOIN student ON student.sid=appointment.pid WHERE schedule.facid=$userid ORDER BY schedule.scheduledate, schedule.scheduletime";
       $result = $database->query($sql);
       while($row = $result->fetch_assoc()){
           $date = $row['scheduledate'];
           if(!isset($appointments[$date])) $appointments[$date] = [];
           $appointments[$date][] = $row;
       }

       // Function to generate calendar
       function generate_calendar($month, $year, $schedules, $appointments) {
           $daysOfWeek = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
           $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
           $numberDays = date('t',$firstDayOfMonth);
           $dateComponents = getdate($firstDayOfMonth);
           $monthName = $dateComponents['month'];
           $dayOfWeek = $dateComponents['wday'];

           $calendar = "<table class='calendar'>";
           $calendar .= "<caption>$monthName $year</caption>";
           $calendar .= "<tr>";
           foreach($daysOfWeek as $day) {
               $calendar .= "<th class='header'>$day</th>";
           }
           $calendar .= "</tr><tr>";

           if ($dayOfWeek > 0) {
               $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
           }

           $currentDay = 1;
           while ($currentDay <= $numberDays) {
               if ($dayOfWeek == 7) {
                   $dayOfWeek = 0;
                   $calendar .= "</tr><tr>";
               }

               $currentDate = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($currentDay, 2, "0", STR_PAD_LEFT);
               $class = 'day';
               $content = $currentDay;
               $hasSession = isset($schedules[$currentDate]);
               $hasAppointment = isset($appointments[$currentDate]);
               if($hasSession){
                   $class .= ' has-session';
                   $content .= '<br><small>' . count($schedules[$currentDate]) . ' sess</small>';
                   if($hasAppointment){
                       $class .= ' has-appointment';
                       $content .= '<br><small>' . count($appointments[$currentDate]) . ' booked</small>';
                   }
               }
               $calendar .= "<td class='$class' data-date='$currentDate'>$content</td>";

               $currentDay++;
               $dayOfWeek++;
           }

           if ($dayOfWeek != 7) {
               $remainingDays = 7 - $dayOfWeek;
               $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
           }

           $calendar .= "</tr>";
           $calendar .= "</table>";
           return $calendar;
       }
    //echo $userid;
    ?>
    <div class="container">
        <div class="menu" id="menu">
        <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" style="width: 91.85px; height: 91.85px; border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="student.php" class="non-style-link-menu"><div><p class="menu-text">My Students</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body" id="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Appointment Manager</p>
                                           
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                        date_default_timezone_set('Asia/Kolkata');

                        $today = date('Y-m-d');
                        echo $today;

                        $list110 = $database->query("select * from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join student on student.sid=appointment.pid inner join faculty on schedule.facid=faculty.facid  where  faculty.facid=$userid ");

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
               
                <!-- <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
                        </a>
                        </div>
                    </td>
                </tr> -->
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Appointments Calendar</p>
                    </td>
                    
                </tr>
                
                <?php


                    $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,faculty.facname,student.sname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join student on student.sid=appointment.pid inner join faculty on schedule.facid=faculty.facid  where  faculty.facid=$userid ";

                    if($_POST){
                        //print_r($_POST);
                        


                        
                        if(!empty($_POST["sheduledate"])){
                            $sheduledate=$_POST["sheduledate"];
                            $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
                        };

                        

                        //echo $sqlmain;

                    }


                ?>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <?php echo generate_calendar(date('m'), date('Y'), $schedules, $appointments); ?>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
   </div>
   <div id="appointment-popup" class="appointment-popup">
       <span class="close" onclick="closePopup()">&times;</span>
       <h3 id="popup-date"></h3>
       <div id="popup-content"></div>
   </div>
   <?php
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='drop'){
            $nameget=$_GET["name"];
            $session=$_GET["session"];
            $apponum=$_GET["apponum"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br><br>
                            Student Name: &nbsp;<b>'.substr($nameget,0,40).'</b><br>
                            Appointment number &nbsp; : <b>'.substr($apponum,0,40).'</b><br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            '; 
        }elseif($action=='view'){
            $sqlmain= "select * from faculty where facid='$id'";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $name=$row["facname"];
            $email=$row["facemail"];
            $spe=$row["subject"];
            $tele=$row['factel'];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="faculty.php">&times;</a>
                        <div class="content">
                            eDoc Web App<br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$name.'<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$email.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$tele.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Subject: </label>

                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$spe.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="faculty.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';  
    }
}

    ?>
    </div>

    <script>
        var schedules = <?php echo json_encode($schedules); ?>;
        var appointments = <?php echo json_encode($appointments); ?>;

        document.addEventListener('DOMContentLoaded', function() {
            var days = document.querySelectorAll('.day.has-session');
            days.forEach(function(day) {
                day.addEventListener('click', function() {
                    var date = this.getAttribute('data-date');
                    showDetails(date);
                });
            });
        });

        function showDetails(date) {
            var popup = document.getElementById('appointment-popup');
            var popupDate = document.getElementById('popup-date');
            var popupContent = document.getElementById('popup-content');

            popupDate.textContent = 'Details for ' + date;
            popupContent.innerHTML = '';

            if (schedules[date]) {
                popupContent.innerHTML += '<h4>Sessions:</h4>';
                schedules[date].forEach(function(sess) {
                    var div = document.createElement('div');
                    div.innerHTML = '<strong>' + sess.title + '</strong> at ' + sess.scheduletime;
                    popupContent.appendChild(div);
                });
            }

            if (appointments[date]) {
                popupContent.innerHTML += '<h4>Booked Appointments:</h4>';
                appointments[date].forEach(function(appt) {
                    var div = document.createElement('div');
                    div.innerHTML = '<strong>' + appt.sname + '</strong> - ' + appt.title + ' at ' + appt.scheduletime + ' (#' + appt.apponum + ') <a href="?action=drop&id=' + appt.appoid + '&name=' + appt.sname + '&session=' + appt.title + '&apponum=' + appt.apponum + '">Cancel</a>';
                    popupContent.appendChild(div);
                });
            }

            if (!schedules[date] && !appointments[date]) {
                popupContent.textContent = 'No sessions or appointments on this date.';
            }

            popup.style.display = 'block';
        }

        function closePopup() {
            document.getElementById('appointment-popup').style.display = 'none';
        }
    </script>

</body>
</html>