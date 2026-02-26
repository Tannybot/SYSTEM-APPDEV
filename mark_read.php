<?php

session_start();

if (!isset($_SESSION["user"])) {
    echo "error";
    exit;
}

// Frontend sends id as query parameter in URL (?id=X)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    include("notification_functions.php");
    mark_as_read($id);
    echo "success";
}
elseif (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    include("notification_functions.php");
    mark_as_read($id);
    echo "success";
}
else {
    echo "error";
}

?>