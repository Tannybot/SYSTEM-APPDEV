<?php
include("connection.php");

// Add status column to appointment table
$sql1 = "ALTER TABLE appointment ADD COLUMN status ENUM('pending', 'done', 'canceled') DEFAULT 'pending'";

if ($database->query($sql1) === TRUE) {
    echo "Status column added to appointment table successfully.<br>";
} else {
    echo "Error adding status column: " . $database->error . "<br>";
}

// Create reviews table
$sql2 = "CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    appoid INT NOT NULL,
    reviewer_type ENUM('faculty', 'student') NOT NULL,
    reviewer_id INT NOT NULL,
    reviewee_id INT NOT NULL,
    rating INT NOT NULL,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1";

if ($database->query($sql2) === TRUE) {
    echo "Reviews table created successfully.<br>";
} else {
    echo "Error creating reviews table: " . $database->error . "<br>";
}
?>