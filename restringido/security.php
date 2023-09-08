<?php
if(!isset($_COOKIE['SessionToken']))
{
    header("location: https://ustoree.azurewebsites.net/index.php");
}

?>