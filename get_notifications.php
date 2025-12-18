<?php

session_start();

if (!isset($_SESSION["user"])) {

    echo json_encode([]);

    exit;

}

$user_email = $_SESSION["user"];

include("notification_functions.php");

$notifications = get_notifications($user_email);

echo json_encode($notifications);

?>