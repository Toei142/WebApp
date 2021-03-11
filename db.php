<?php
    define("hostname","localhost");
    define("username",'user');
    define("password","ec1L9W4hnfSNcQia");
    define("dbname","bookstore");
?>
<?php
    $conn=new mysqli(hostname,username,password,dbname);
    $conn->query("SELECT * FROM `book` WHERE 1");
    if($conn->connect_error) echo "not connect";
    else echo "Connect success";
   
?>
