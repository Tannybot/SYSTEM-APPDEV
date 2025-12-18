<?php

session_start();

if (!isset($_SESSION["user"])) {

    echo "error";

    exit;

}

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    include("notification_functions.php");

    dismiss_notification($id);

    echo "success";

} else {

    echo "error";

}

?>