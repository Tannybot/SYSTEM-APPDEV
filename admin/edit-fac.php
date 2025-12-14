
    <?php
    
    

    //import database
    include("../connection.php");



    if($_POST){
        //print_r($_POST);
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $oldemail=$_POST["oldemail"];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){
            $error='3';
            $result= $database->query("select faculty.facid from faculty inner join webuser on faculty.facemail=webuser.email where webuser.email='$email';");
            //$resultqq= $database->query("select * from faculty where facid='$id';");
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["facid"];
            }else{
                $id2=$id;
            }

            if($id2!=$id){
                $error='1';
                //$resultqq1= $database->query("select * from faculty where facemail='$email';");
                //$did= $resultqq1->fetch_assoc()["facid"];
                //if($resultqq1->num_rows==1){

            }else{

                //$sql1="insert into faculty(facemail,facname,facpassword,facnic,factel,subject) values('$email','$name','$password','$nic','$tele',$spec);";
                $sql1="update faculty set facemail='$email',facname='$name',facpassword='$password',factel='$tele',subject=$spec where facid=$id ;";
                $database->query($sql1);
                
                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);
                //echo $sql1;
                //echo $sql2;
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: faculty.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>