<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Sessions</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 's') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

// import database
include("../connection.php");

$sqlmain = "select * from student where semail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$result = $stmt->get_result();
$userfetch = $result->fetch_assoc();
$userid = $userfetch["sid"];
$username = $userfetch["sname"];

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
?>

<div class="container">
    <div class="menu">
        <table class="menu-container" border="0">
            <tr>
                <td style="padding:10px" colspan="2">
                    <table border="0" class="profile-container">
                        <tr>
                            <td width="30%" style="padding-left:20px">
                                <img src="../img/<?php echo $userfetch['profile_image'] ?: 'user.png'; ?>" style="width: 91.85px; height: 91.85px; border-radius:50%">
                            </td>
                            <td>
                                <p class="profile-title"><?php echo substr($username, 0, 13) ?>..</p>
                                <p class="profile-subtitle"><?php echo substr($useremail, 0, 22) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="../logout.php">
                                    <input type="button" value="Log out" class="logout-btn btn-primary-soft btn">
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-home">
                    <a href="index.php" class="non-style-link-menu">
                        <div><p class="menu-text">Home</p></div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-faculty">
                    <a href="faculty.php" class="non-style-link-menu">
                        <div><p class="menu-text">All Faculty</p></div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                    <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active">
                        <div><p class="menu-text">Scheduled Sessions</p></div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-appoinment">
                    <a href="appointment.php" class="non-style-link-menu">
                        <div><p class="menu-text">My Bookings</p></div>
                    </a>
                </td>
            </tr>

            <tr class="menu-row">
                <td class="menu-btn menu-icon-settings">
                    <a href="settings.php" class="non-style-link-menu">
                        <div><p class="menu-text">Settings</p></div>
                    </a>
                </td>
            </tr>
        </table>
    </div>

    <div class="dash-body">
        <table border="0" width="100%" style="margin-top:25px;">
            <tr>
                <td width="13%">
                    <a href="index.php">
                        <button class="login-btn btn-primary-soft btn btn-icon-back" 
                        style="padding:11px;margin-left:20px;width:125px;">
                            <font class="tn-in-text">Back</font>
                        </button>
                    </a>
                </td>

                <td>
                    <form action="schedule.php" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar" 
                        placeholder="Search Faculty name or Email or Date (YYYY-MM-DD)" list="faculty">

                        <?php
                        echo '<datalist id="faculty">';
                        $list11 = $database->query("select DISTINCT * from faculty;");
                        $list12 = $database->query("select DISTINCT * from schedule GROUP BY title;");

                        while ($row00 = $list11->fetch_assoc()) {
                            echo "<option value='{$row00["facname"]}'>";
                        }
                        while ($row00 = $list12->fetch_assoc()) {
                            echo "<option value='{$row00["title"]}'>";
                        }
                        echo '</datalist>';
                        ?>

                        <input type="Submit" value="Search" class="login-btn btn-primary btn" 
                        style="padding:10px 25px;">
                    </form>
                </td>

                <td width="15%">
                    <p style="font-size:14px;color:#777;text-align:right;">Today's Date</p>
                    <p class="heading-sub12"><?php echo $today; ?></p>
                </td>

                <td width="10%">
                    <button class="btn-label">
                        <img src="../img/calendar.svg" width="100%">
                    </button>
                </td>
            </tr>

            <tr><td colspan="4"></td></tr>

            <tr>
                <td colspan="4">
                    <center>
                    <div class="abc scroll">
                    <table class="sub-table scrolldown" width="100%" style="padding:50px;border:none;">
                        <tbody>

                        <?php
                        if ($_GET) {
                            if (isset($_GET["id"])) {

                                $id = $_GET["id"];

                                $sqlmain = "select * from schedule 
                                    inner join faculty on schedule.facid = faculty.facid 
                                    where schedule.scheduleid=? 
                                    order by schedule.scheduledate desc";

                                $stmt = $database->prepare($sqlmain);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();

                                $scheduleid = $row["scheduleid"];
                                $title = $row["title"];
                                $facname = $row["facname"];
                                $facemail = $row["facemail"];
                                $scheduledate = $row["scheduledate"];
                                $scheduletime = $row["scheduletime"];
                                $nop = $row["nop"];

                                $sql2 = "select * from appointment where scheduleid=$id";
                                $result12 = $database->query($sql2);
                                $current_bookings = $result12->num_rows;

                                if ($current_bookings >= $nop) {

                                    echo '
                                    <tr>
                                        <td colspan="4">
                                            <br><br><br>
                                            <center>
                                                <img src="../img/notfound.svg" width="25%">
                                                <p class="heading-main12" style="font-size:20px;">Session Full</p>
                                                <p class="heading-main12" style="font-size:16px;">
                                                    This appointment has reached its maximum capacity of '.$nop.' students.
                                                </p>
                                                <a class="non-style-link" href="schedule.php">
                                                    <button class="login-btn btn-primary-soft btn">View Other Sessions</button>
                                                </a>
                                            </center>
                                            <br><br><br>
                                        </td>
                                    </tr>';

                                } else {

                                    $apponum = $current_bookings + 1;

                                    echo '
                                    <form action="booking-complete.php" method="post">
                                        <input type="hidden" name="scheduleid" value="'.$scheduleid.'">
                                        <input type="hidden" name="apponum" value="'.$apponum.'">
                                        <input type="hidden" name="date" value="'.$today.'">

                                    <tr>
                                        <td style="width:50%;" rowspan="2">
                                            <div class="dashboard-items search-items">
                                                <div style="width:100%">
                                                    <div class="h1-search" style="font-size:25px;">Session Details</div>
                                                    <br>
                                                    <div class="h3-search" style="font-size:18px;">
                                                        Faculty name: <b>'.$facname.'</b><br>
                                                        Faculty Email: <b>'.$facemail.'</b>
                                                    </div>
                                                    <br>
                                                    <div class="h3-search" style="font-size:18px;">
                                                        Session Title: '.$title.'<br>
                                                        Date: '.$scheduledate.'<br>
                                                        Starts at: '.$scheduletime.'<br>
                                                        Channeling Fee: <b>LKR. 2,000.00</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td style="width:25%;">
                                            <div class="dashboard-items search-items">
                                                <div style="padding:15px;">
                                                    <div class="h1-search" style="font-size:20px;text-align:center;">
                                                        Your Appointment Number
                                                    </div>
                                                    <center>
                                                        <div class="dashboard-icons"
                                                        style="width:90%;font-size:70px;font-weight:800;">
                                                            '.$apponum.'
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="Submit" class="login-btn btn-primary btn btn-book" 
                                            style="width:95%;" value="Book now" name="booknow">
                                        </td>
                                    </tr>

                                    </form>
                                    ';
                                }
                            }
                        }
                        ?>

                        </tbody>
                    </table>
                    </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
