<?php
include("connection.php");

$sql = "ALTER TABLE schedule ADD COLUMN purpose TEXT";

if ($database->query($sql) === TRUE) {
    echo "Purpose column added to schedule table successfully.";
} else {
    echo "Error adding purpose column: " . $database->error;
}
?>