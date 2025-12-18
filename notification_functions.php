<?php

include("connection.php");

function add_notification($user_email, $type, $message) {
    global $database;
    $stmt = $database->prepare("INSERT INTO notifications (user_email, type, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_email, $type, $message);
    $stmt->execute();
    $stmt->close();
}

function get_notifications($user_email, $only_unread = false) {
    global $database;
    $query = "SELECT * FROM notifications WHERE user_email = ? AND dismissed = 0";
    if ($only_unread) {
        $query .= " AND is_read = 0";
    }
    $query .= " ORDER BY created_at DESC";
    $stmt = $database->prepare($query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    $stmt->close();
    return $notifications;
}

function get_unread_count($user_email) {
    global $database;
    $stmt = $database->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_email = ? AND is_read = 0 AND dismissed = 0");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['count'];
}

function mark_as_read($id) {
    global $database;
    $stmt = $database->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function dismiss_notification($id) {
    global $database;
    $stmt = $database->prepare("UPDATE notifications SET dismissed = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

?>