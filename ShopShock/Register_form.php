<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="margin: 0 auto ; width:500px;border:2px red solid;padding:50px">
        <form action="rest.php" method="post">
            <h1 style="margin: 0;">ShopShock Member Register</h1><br>
            <table style="margin-right: auto;margin-left: auto;">
            <input type="hidden" name="Register">
                <tr>
                    <td><label for="">Name</label></td>
                    <td><input type="text" name="name" id=""></td>
                </tr>
                <tr>
                    <td><label for="">NickName</label></td>
                    <td><input type="text" name="nickname" id=""></td>
                </tr>
                <tr>
                    <td><label for="">Password</label></td>
                    <td><input type="text" name="pass" id=""></td>
                </tr>
                <tr>
                    <td><label for="">Confirm Password</label></td>
                    <td><input type="text" name="con_pass" id=""></td>
                </tr>
                <tr style="text-align: center;">
                    <td><button type="submit">submit</button></td>
                    <td><button type="reset">Reset</button></td>
                </tr>

            </table>
        </form>
    </div>
</body>

</html>