<?php
    session_start();
    if ($_SESSION == null) {
        header('Location:Login.php');
    }
