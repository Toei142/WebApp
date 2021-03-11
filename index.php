<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid grey;
           
        }
        td,th,tr{
            padding:10px;
        }
    </style>
</head>

<body>
    <?php
    include_once "db.php";
    $myConn = new Database();
    $myConn->showBook();
    $myConn->disconnect();
    ?>
</body>

</html>