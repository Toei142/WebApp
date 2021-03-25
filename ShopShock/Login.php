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
        <h1 style="text-align: center;">SHOPSHOCK</h1>
        <h4 style="text-align: center;">กรุณากรอกชื่อผู้ใช้และรหัสผ่านเพื่อเข้าสู่ระบบ</h4>
        <table style="margin-right: auto;margin-left: auto;">
            <tr>
                <input type="hidden" name="login">
                <td><label for="">username : </label></td>
                <td><input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td><label for="">password : </label></td>
                <td><input type="text" name="password" id="password"></td>
            </tr>
            <tr>
                <td> <button type="submit" onclick="login()">Login</button></td>
            </tr>
        </table>
        <script>
            function login() {
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ

                        if (this.responseText == 1) {
                            alert("ยินดีต้อนรับ");
                            location.href = "ProductList.php";
                        } else {
                            alert(this.responseText);
                        }
                    }
                }
                u = document.getElementById("username");
                p = document.getElementById("password");
                xhttp.open("POST", "rest.php");
                xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                xhttp.send("login=''&username=" + u.value + "&password=" + p.value);
            }
        </script>
    </div>
</body>

</html>