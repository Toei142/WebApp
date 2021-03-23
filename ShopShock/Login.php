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
            <h1 style="text-align: center;">SHOPSHOCK</h1>
            <h4 style="text-align: center;">กรุณากรอกชื่อผู้ใช้และรหัสผ่านเพื่อเข้าสู่ระบบ</h4>
            <table style="margin-right: auto;margin-left: auto;">
                <tr>
                    <input type="hidden" name="login">
                    <td><label for="">username : </label></td>
                    <td><input type="text" name="username" id=""></td>
                </tr>
                <tr>
                    <td><label for="">password : </label></td>
                    <td><input type="text" name="password" id=""></td>
                </tr>
                <tr>
                    <td> <button type="submit">Login</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>