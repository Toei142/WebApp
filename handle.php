<?php
    require_once "db.php";
    $myconn=new Database();
    $data['id']=$_POST['id'];
    $data['name']=$_POST['name'];
    $data['type']=$_POST['type'];
    $data['status']=$_POST['status'];
    $data['pub']=$_POST['pub'];
    $data['unitp']=$_POST['unitp'];
    $data['unitr']=$_POST['unitr'];
    $data['day']=$_POST['day'];
    $data['pic']=$_POST['pic'];
    $myconn->insertData($data);
    header("location: index.php");
?>