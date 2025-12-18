<?php

session_start();

if (!isset($_SESSION["user"])) {

    echo "error";

    exit;

}

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    include("notification_functions.php");

    mark_as_read($id);

    echo "success";

} else {

    echo "error";

}

?>