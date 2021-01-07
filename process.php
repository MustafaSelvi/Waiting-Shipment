<?php
require_once('connection.php');
session_start();
    if(isset($_POST['Login']))
    {
        if(empty($_POST['email']) || empty($_POST['password'])){
            header("location:login.php?Empty= Please Fill in the Blanks");
        }
        else 
        {
            $query="select * from customer_info where email='".$_POST['email']."' and Password='".$_POST['password']."'";
            $result=mysqli_query($con,$query);
    
            if(mysqli_fetch_assoc($result))
            {
                $_SESSION['email']=$_POST['email'];
                $_SESSION['loggedin'] = true;
                header("location:index.php");

                if($_POST['email']=="admin" && $_POST['password']==123456){
                    $_SESSION['adminLoggedin'] = true;
                }
            }
            else
            {
                header("location:login.php?Invalid= Please Enter Correct Email and Password ");
            }
        }
    }
    else
    {
        echo 'Not Working Now Guys';
    }

?>