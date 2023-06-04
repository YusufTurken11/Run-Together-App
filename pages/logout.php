<?php
if (isset($_SESSION['User'])){
    session_destroy();
    header("Location:index.php");
}else{
    header("Location:index.php?page=1");
    exit();
}