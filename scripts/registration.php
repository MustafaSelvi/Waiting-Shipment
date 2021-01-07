<?php
require_once('../connection.php');
session_start();
    if(isset($_POST['Register']))
    {

        $username = $_POST["name"];  
        $lastname = $_POST["lastname"];
        $password = $_POST["password"];  
        $email = $_POST["email"]; 
        $phone = $_POST["phone"]; 
        $comppany = $_POST["companyName"]; 

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header ("Location:../register.php?Invalid= Email Address Format Invalid!"); 
          }
          else
          {
            if(empty($_POST['email']) || empty($_POST['password'])){
                header("location:../register.php?Empty= Please Fill in the Blanks");
            }
            else 
            {
                $sql = "Select * from customer_info where email='$email'"; 
        
                $result = mysqli_query($con, $sql); 
                
                $num = mysqli_num_rows($result); 
    
                if ($num == 0) {
                    $sql="insert into customer_info values('','$username','$lastname','$email','$phone','$comppany','','0','0','$password')";
                    $result = mysqli_query($con, $sql); 
                    header ("Location:../login.php?Success= Account Created Successfully.");
                }
                else
                {  
                header ("Location:../register.php?Exist= Email Already Exists!"); 
                }           
            }

          }
    }
    else
    {
        echo 'Error';
    }

?>