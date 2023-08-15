<?php
session_start();
if(!isset($_COOKIE['SessionToken']))
{
    header("location: ../index.php");
}

?>