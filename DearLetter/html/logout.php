<?php
    session_start();
    
    require_once "../configs/utils.php";

    session_destroy();

    header ("Location:login.php");
?>