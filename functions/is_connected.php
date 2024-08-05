<?php
    session_start();
    echo isset($_SESSION['user']) ? true : false;
?>