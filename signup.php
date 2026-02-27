<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/livewallpaper.css">
        
    <title>Sign Up - ConsultEase</title>
    
</head>
<body>
<?php include("includes/livewallpaper.php"); ?>
<?php

session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

if ($_POST) {
    $role = $_POST['role'];

    if ($role == 'student') {
        header("location: student-signup.php");
        exit();
    }
    elseif ($role == 'faculty') {
        header("location: faculty-signup.php");
        exit();
    }
    else {
        $error = "Please select a role.";
    }
}

?>

<div class="center-wrapper">
    <div class="container">
        <form action="" method="POST">
            <div class="form-inner">
                <p class="header-text">Let's Get Started</p>
                <p class="sub-text">Select Your Role to Continue</p>

                <div class="form-group">
                    <label class="form-label">I am a:</label>
                </div>
                <div class="form-group role-options">
                    <label class="role-card">
                        <input type="radio" name="role" value="student" required>
                        <span class="role-label">🎓 Student</span>
                    </label>
                    <label class="role-card">
                        <input type="radio" name="role" value="faculty" required>
                        <span class="role-label">👨‍🏫 Faculty</span>
                    </label>
                </div>

                <div class="form-group">
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </div>

                <div class="form-group" style="text-align:center;">
                    <label class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>