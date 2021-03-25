<?php
    session_start();
    if ($_SESSION['member_id'] == null) {
        header('Location:Login.php');
    }
