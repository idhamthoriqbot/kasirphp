<?php

require 'function.php';

if(isset($_SESSION['login'])){
    //jika true maka sudah login
} else {
    //jika false di suruh login
    header('location:login.php');
}

?>