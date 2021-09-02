<?php

include "config.php";

if($_SESSION['role'] == '0')
    {
        header("Location: {$host}admin/post.php");
    }
?>