<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='f'){
            header("location: ../login.php");
            exit();
        }

    }else{
        header("location: ../login.php");
            exit();
    }


    if($_GET){
        //import database
        include("../connection.php");
        $id=$_GET["id"];
        $sql= $database->query("UPDATE appointment SET status='canceled' WHERE appoid='$id'");
        header("location: appointment.php");
    }


?>