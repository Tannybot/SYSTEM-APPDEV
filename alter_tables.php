<?php
include("connection.php");

$sql = "DROP TABLE IF EXISTS `faculty_availability`;
CREATE TABLE IF NOT EXISTS `faculty_availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facid` int(11) NOT NULL,
  `day_of_week` int(1) NOT NULL COMMENT '1=Monday, 2=Tuesday, ..., 7=Sunday',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `facid` (`facid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

if ($database->multi_query($sql)) {
    echo "Table faculty_availability created successfully.";
} else {
    echo "Error creating table: " . $database->error;
}
?>