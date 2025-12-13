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

//import database
include("../connection.php");

$userrow = $database->query("select * from faculty where facemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["facid"];

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])){
    $file = $_FILES['profile_image'];

    // Check for errors
    if($file['error'] !== UPLOAD_ERR_OK){
        $error = "Upload failed with error code " . $file['error'];
    }else{
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if(!in_array($file['type'], $allowed_types)){
            $error = "Invalid file type. Only JPG, PNG, GIF allowed.";
        }else{
            // Validate file size (max 2MB)
            if($file['size'] > 2 * 1024 * 1024){
                $error = "File too large. Max 2MB.";
            }else{
                // Generate unique filename
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = "faculty_" . $userid . "_" . time() . "." . $ext;
                $target_path = "../img/" . $filename;

                // Move uploaded file
                if(move_uploaded_file($file['tmp_name'], $target_path)){
                    // Update database
                    $sql = "UPDATE faculty SET profile_image = ? WHERE facid = ?";
                    $stmt = $database->prepare($sql);
                    $stmt->bind_param("si", $filename, $userid);
                    if($stmt->execute()){
                        $success = "Profile image updated successfully.";
                    }else{
                        $error = "Database update failed.";
                    }
                }else{
                    $error = "Failed to save file.";
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Upload Profile Image</title>
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
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td style="padding:0px;margin:0px;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="../img/<?php echo $userfetch['profile_image'] ?: 'user.png'; ?>" alt="Profile" style="width: 20px; height: 20px; margin-right: 8px; border-radius: 50%;">
                                        <div>
                                            <p class="profile-title"><?php echo substr($userfetch["facname"],0,13)  ?>..</p>
                                            <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                        </div>
                                    </div>
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
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></a></div></a>
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
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >

                        <tr >

                        <td width="13%" >
                    <a href="settings.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Upload Profile Image</p>

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
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div>
                                                <div class="h1-dashboard">
                                                    Current Profile Image

                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px;">
                                                    <img src="../img/<?php echo $userfetch['profile_image'] ?: 'user.png'; ?>" alt="Current Profile" style="width: 100px; height: 100px; border-radius: 50%;">
                                                </div>
                                        </div>

                                    </div>
                                </td>


                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                                <div class="h1-dashboard" >
                                                    Upload New Image

                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    Select a new profile image (JPG, PNG, GIF, max 2MB)
                                                </div>
                                        </div>

                                    </div>
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
    if(isset($error)){
        echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                <br><br><br><br>
                    <h2>Upload Failed!</h2>
                    <a class="close" href="upload-profile-faculty.php">&times;</a>
                    <div class="content">
                        '.$error.'

                    </div>
                    <div style="display: flex;justify-content: center;">

                    <a href="upload-profile-faculty.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                    </div>
                    <br><br>
                </center>
    </div>
    </div>
';
    }elseif(isset($success)){
        echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                <br><br><br><br>
                    <h2>Upload Successful!</h2>
                    <a class="close" href="settings.php">&times;</a>
                    <div class="content">
                        '.$success.'

                    </div>
                    <div style="display: flex;justify-content: center;">

                    <a href="settings.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                    </div>
                    <br><br>
                </center>
    </div>
    </div>
';
    }else{
        echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>


                    <div style="display: flex;justify-content: center;">
                    <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                            <td class="label-td" colspan="2">'.
                                '<form action="upload-profile-faculty.php" method="POST" enctype="multipart/form-data">
                                <label for="profile_image" class="form-label">Select Profile Image: </label>
                                <input type="file" name="profile_image" id="profile_image" class="input-text" accept="image/*" required><br><br>
                                <input type="submit" value="Upload" class="login-btn btn-primary btn">
                                </form>'
                            .'</td>
                        </tr>
                    </table>
                    </div>
                    </div>
                </center>
    </div>
    </div>
';
    }
    ?>

</body>
</html>