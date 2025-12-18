<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        


    <title>Settings</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-X  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
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


    //echo $userid;
    //echo $username;
    
    ?>
    <div class="container">
        <div class="menu">
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
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-student">
                        <a href="student.php" class="non-style-link-menu"><div><p class="menu-text">My Students</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings  menu-active menu-icon-settings-active">
                        <a href="settings.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                        <td width="13%" >
                    <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Settings</p>
                                           
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


                                $studentrow = $database->query("select  * from  student;");
                                $facultyrow = $database->query("select  * from  faculty;");
                                $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");
                                $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");


                                ?>
                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                <tr>
                    <td colspan="4">
                        
                        <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">
                                    <a href="?action=edit&id=<?php echo $userid ?>&error=0" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/faculty-hover.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                    Account Settings  &nbsp;

                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px;">
                                                    Edit your Account Details & Change Password
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                                
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=view&id=<?php echo $userid ?>" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting " style="background-image: url('../img/icons/view-iceblue.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard" >
                                                    View Account Details
                                                    
                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    View Personal information About Your Account
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=availability&id=<?php echo $userid ?>" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/schedule-hover.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                    Availability Settings

                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    Set your available days and time slots
                                                </div>
                                        </div>

                                    </div>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=history&id=<?php echo $userid ?>" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/view-iceblue.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                    Booking History  &nbsp;

                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px;">
                                                    View completed appointments
                                                </div>
                                        </div>
                                            

                                    </div>
                                    </a>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=drop&id=<?php echo $userid.'&name='.$username ?>" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/students-hover.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard" style="color: #ff5050;">
                                                    Delete Account

                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    Will Permanently Remove your Account
                                                </div>
                                        </div>

                                    </div>
                                    </a>
                                </td>

                            </tr>
                        </table>
                    </center>
                    </td>
                </tr>
            
            </table>
        </div>
    </div>
    <?php 
    if($_GET){
        
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='drop'){
            $nameget=$_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="settings.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>('.substr($nameget,0,40).').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-faculty.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

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
                        <a class="close" href="settings.php">&times;</a>
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
                                    <a href="settings.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        }elseif($action=='availability'){
            $sqlmain= "select * from faculty_availability where facid='$id' order by day_of_week";
            $result= $database->query($sqlmain);
            $availabilities = [];
            while($row = $result->fetch_assoc()){
                $availabilities[$row['day_of_week']][] = $row;
            }

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <a class="close" href="settings.php">&times;</a>
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                                <td class="label-td" colspan="2">'.
                                    ""

                                .'</td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Set Your Availability</p><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <form action="edit-fac.php" method="POST" class="add-new-form">
                                    <input type="hidden" name="action" value="update_availability">
                                    <input type="hidden" value="'.$id.'" name="facid">
';

            echo '<table border="0" style="width:100%">';
            $col = 0;
            for($d=1; $d<=7; $d++){
                if($col == 0) echo '<tr>';
                $day_name = $days[$d-1];
                $slots = isset($availabilities[$d]) ? $availabilities[$d] : [];
                echo '<td style="padding:10px; vertical-align:top;">
                    <label for="day'.$d.'" class="form-label"><b>'.$day_name.'</b></label><br>
                    Start Time: <input type="time" name="start_time['.$d.'][]" value="'.(isset($slots[0]) ? $slots[0]['start_time'] : '').'" class="input-text"><br>
                    End Time: <input type="time" name="end_time['.$d.'][]" value="'.(isset($slots[0]) ? $slots[0]['end_time'] : '').'" class="input-text">
                </td>';
                $col++;
                if($col == 5) {
                    echo '</tr>';
                    $col = 0;
                }
            }
            if($col > 0) {

                for($i=$col; $i<5; $i++) echo '<td style="padding:10px;"></td>';

                echo '</tr>';

            }
            echo '</table>';

            echo '
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <input type="submit" value="Save Availability" class="login-btn btn-primary btn">
                                </td>

                            </tr>

                            </form>
                            </tr>
                        </table>
                        </div>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
       }elseif($action=='history'){
           $where = "schedule.facid = '$id' AND appointment.status = 'done'";
           if(!empty($_GET['from_date'])) $where .= " AND appointment.appodate >= '".$_GET['from_date']."'";
           if(!empty($_GET['to_date'])) $where .= " AND appointment.appodate <= '".$_GET['to_date']."'";
           if(!empty($_GET['subject'])) $where .= " AND faculty.subject = '".$_GET['subject']."'";
           $sqlmain = "SELECT appointment.appoid, appointment.appodate, schedule.scheduletime, schedule.title, subject.sname as subject_name, appointment.status
                       FROM appointment
                       INNER JOIN schedule ON appointment.scheduleid = schedule.scheduleid
                       INNER JOIN faculty ON schedule.facid = faculty.facid
                       INNER JOIN subject ON faculty.subject = subject.id
                       WHERE $where
                       ORDER BY appointment.appodate DESC, schedule.scheduletime DESC";
           $result = $database->query($sqlmain);
           $bookings = [];
           while($row = $result->fetch_assoc()){
               $bookings[] = $row;
           }
           echo '
           <div id="popup1" class="overlay">
                   <div class="popup">
                   <center>
                       <a class="close" href="settings.php">&times;</a>
                       <div style="display: flex;justify-content: center;">
                       <div class="abc" style="width: 90%; max-width: 1200px;">
                       <table width="100%" class="sub-table scrolldown add-doc-form-container" border="0">
                       <tr>
                               <td>
                                   <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Booking History</p><br>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <form method="GET" action="settings.php">
                                       <input type="hidden" name="action" value="history">
                                       <input type="hidden" name="id" value="'.$id.'">
                                       <label>Date Range: From </label>
                                       <input type="date" name="from_date" value="'.($_GET['from_date'] ?? '').'">
                                       <label> To </label>
                                       <input type="date" name="to_date" value="'.($_GET['to_date'] ?? '').'">
                                       <label> Booking Type: </label>
                                       <select name="subject">
                                           <option value="">All</option>';
                                           $subjects = $database->query("SELECT id, sname FROM subject");
                                           while($sub = $subjects->fetch_assoc()){
                                               $selected = ($_GET['subject'] == $sub['id']) ? 'selected' : '';
                                               echo '<option value="'.$sub['id'].'" '.$selected.'>'.$sub['sname'].'</option>';
                                           }
                                       echo '</select>
                                       <input type="submit" value="Filter" class="btn-primary btn">
                                   </form>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <button onclick="downloadCSV()" class="btn-primary btn">Download to Excel</button>
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <table class="filter-container" border="1" style="width:100%; border-collapse: collapse;">
                                       <thead>
                                           <tr>
                                               <th onclick="sortTable(0)">Booking ID <span id="sort-icon-0">↕</span></th>
                                               <th onclick="sortTable(1)">Date <span id="sort-icon-1">↕</span></th>
                                               <th onclick="sortTable(2)">Time <span id="sort-icon-2">↕</span></th>
                                               <th onclick="sortTable(3)">Room/Facility <span id="sort-icon-3">↕</span></th>
                                               <th onclick="sortTable(4)">Purpose <span id="sort-icon-4">↕</span></th>
                                               <th onclick="sortTable(5)">Status <span id="sort-icon-5">↕</span></th>
                                           </tr>
                                       </thead>
                                       <tbody id="booking-table">';
                                       foreach($bookings as $booking){
                                           echo '<tr>
                                               <td>'.$booking['appoid'].'</td>
                                               <td>'.$booking['appodate'].'</td>
                                               <td>'.$booking['scheduletime'].'</td>
                                               <td>'.$booking['title'].'</td>
                                               <td>'.$booking['subject_name'].'</td>
                                               <td>'.$booking['status'].'</td>
                                           </tr>';
                                       }
                                       echo '</tbody>
                                   </table>
                               </td>
                           </tr>
                       </table>
                       </div>
                       </div>
                   </center>
                   <br><br>
           </div>
           </div>
           ';
       }elseif($action=='edit'){
            $sqlmain= "select * from faculty where facid='$id'";
            $result= $database->query($sqlmain);
            $row=$result->fetch_assoc();
            $name=$row["facname"];
            $email=$row["facemail"];
            $spe=$row["subject"];
            $tele=$row['factel'];

            $error_1=$_GET["error"];
                $errorlist= array(
                    '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
                    '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>',
                    '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                    '4'=>"",
                    '0'=>'',

                );

            if($error_1!='4'){
                    echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            
                                <a class="close" href="settings.php">&times;</a> 
                                <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                        <td class="label-td" colspan="2">'.
                                            $errorlist[$error_1]
                                        .'</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Faculty Details.</p>
                                        Faculty ID : '.$id.' (Auto Generated)<br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="edit-fac.php" method="POST" class="add-new-form">
                                            <label for="Email" class="form-label">Email: </label>
                                            <input type="hidden" value="'.$id.'" name="id00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <input type="hidden" name="oldemail" value="'.$email.'" >
                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="'.$email.'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="name" class="input-text" placeholder="Faculty Name" value="'.$name.'" required><br>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">Telephone: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="'.$tele.'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="spec" class="form-label">Subject: (Current'.$spe.')</label>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="spec" class="input-text" placeholder="Enter Subject" value="'.$spe.'" required><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="password" class="form-label">Password: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="password" name="password" class="input-text" placeholder="Define a Password" required><br>
                                        </td>
                                    </tr><tr>
                                        <td class="label-td" colspan="2">
                                            <label for="cpassword" class="form-label">Confirm Password: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required><br>
                                        </td>
                                    </tr>
                                    
                        
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                            <input type="submit" value="Save" class="login-btn btn-primary btn">
                                        </td>
                        
                                    </tr>
                                
                                    </form>
                                    </tr>
                                </table>
                                </div>
                                </div>
                            </center>
                            <br><br>
                    </div>
                    </div>
                    ';
        }else{
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                        <br><br><br><br>
                            <h2>Edit Successfully!</h2>
                            <a class="close" href="settings.php">&times;</a>
                            <div class="content">
                                If You change your email also Please logout and login again with your new email
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            
                            <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                            <a href="../logout.php" class="non-style-link"><button  class="btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Log out&nbsp;&nbsp;</font></button></a>

                            </div>
                            <br><br>
                        </center>
                </div>
                </div>
    ';



        }; }
    }
        ?>

<script>

function sortTable(n) {

  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;

  table = document.getElementById("booking-table");

  switching = true;

  dir = "asc";

  while (switching) {

    switching = false;

    rows = table.rows;

    for (i = 0; i < (rows.length - 1); i++) {

      shouldSwitch = false;

      x = rows[i].getElementsByTagName("TD")[n];

      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (dir == "asc") {

        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

          shouldSwitch = true;

          break;

        }

      } else if (dir == "desc") {

        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {

          shouldSwitch = true;

          break;

        }

      }

    }

    if (shouldSwitch) {

      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);

      switching = true;

      switchcount ++;

    } else {

      if (switchcount == 0 && dir == "asc") {

        dir = "desc";

        switching = true;

      }

    }

  }

  // Update sort icons

  for (var j = 0; j < 6; j++) {

    document.getElementById("sort-icon-" + j).innerHTML = "↕";

  }

  document.getElementById("sort-icon-" + n).innerHTML = (dir == "asc") ? "↑" : "↓";

}

function downloadCSV() {

  var table = document.getElementById("booking-table");

  var csv = [];

  var rows = table.rows;

  for (var i = 0; i < rows.length; i++) {

    var row = [], cols = rows[i].querySelectorAll("td, th");

    for (var j = 0; j < cols.length; j++) {

      row.push(cols[j].innerText);

    }

    csv.push(row.join(","));

  }

  var csv_string = csv.join("\n");

  var filename = 'booking_history_' + new Date().toISOString().slice(0,10) + '.csv';

  var link = document.createElement('a');

  link.style.display = 'none';

  link.setAttribute('target', '_blank');

  link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));

  link.setAttribute('download', filename);

  document.body.appendChild(link);

  link.click();

  document.body.removeChild(link);

}

</script>

</body>
</html>