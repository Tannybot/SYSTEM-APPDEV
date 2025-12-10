
    <?php
    
    

    //import database
    include("../connection.php");



    if($_POST){
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $oldemail=$_POST["oldemail"];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele_raw = $_POST['Tele'];
        $tele = (strpos($tele_raw, '+63') === 0) ? $tele_raw : '+63' . $tele_raw;
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];

        if ($password==$cpassword){
            $error='3';
            $query_select = "select faculty.facid from faculty inner join webuser on faculty.facemail=webuser.email where webuser.email='$email';";
            error_log("SELECT query: " . $query_select);
            $result= $database->query($query_select);
            error_log("SELECT result num_rows: " . $result->num_rows);
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["facid"];
                error_log("Fetched facid: " . $id2);
            }else{
                $id2=$id;
                error_log("Using provided id: " . $id2);
            }

            if($id2!=$id){
                $error='1';
                error_log("ID mismatch: id2=$id2, id=$id");
            }else{
                $sql1="update faculty set facemail='$email',facname='$name',facpassword='$password',factel='$tele',subject=$spec where facid=$id ;";
                error_log("UPDATE faculty query: " . $sql1);
                $database->query($sql1);

                $sql2="update webuser set email='$email' where email='$oldemail' ;";
                error_log("UPDATE webuser query: " . $sql2);
                $database->query($sql2);

                $error= '4';

            }

        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>