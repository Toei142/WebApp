<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <form action="handle.php" method="post">
        <table>
            <tr>
                <td><label for="">BookID</label></td>
                <td><input type="text" name="id" id="" required></td>
            </tr>
            <tr>
                <td><label for="">BookName</label></td>
                <td><input type="text" name="name" id="" required></td>
            </tr>
            <tr>
                <td><label for="">Type</label></td>
                <td>
                    <?php
                    require_once "db.php";
                    $myconn = new Database();
                    $myconn->sltType();
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="">Status</label></td>
                <td>
                    <?php
                    require_once "db.php";
                    $myconn = new Database();
                    $myconn->sltStatus();
                    ?>
                </td>
            </tr>
            <tr>
                <td><label for="">Publish</label></td>
                <td><input type="text" name="pub" id="" required></td>
            </tr>
            <tr>
                <td><label for="">Unit Price</label></td>
                <td><input type="text" name="unitp" id="" required></td>
            </tr>
            <tr>
                <td><label for="">Unit Rent</label></td>
                <td><input type="text" name="unitr" id="" required></td>
            </tr>
            <tr>
                <td><label for="">DayAmount</label></td>
                <td><input type="text" name="day" id="" required></td>
            </tr>
            <tr>
                <td><label for="">Picture</label></td>
                <td><input type="text" name="pic" id="" required></td>
            </tr>
            <tr>
                <td rowspan="2"><button type="submit">Save</button></td>
            </tr>
        </table>
    </form>
</body>

</html>