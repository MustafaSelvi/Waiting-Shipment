<?php

    $con = mysqli_connect('localhost','root','','shipping_automation');

    if(!$con)
    {
        die(' Please Check Your Connection'.mysqli_error($con));
    }

?>