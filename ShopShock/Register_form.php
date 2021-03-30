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
        <h1 style="margin: 0;">ShopShock Member Register</h1><br>
        <table style="margin-right: auto;margin-left: auto;">
            <tr>
                <td><label for="">Name</label></td>
                <td><input type="text" name="fname" id="fname"></td>
            </tr>
            <tr>
                <td><label for="">NickName</label></td>
                <td><input type="text" name="nickname" id="nickname"></td>
            </tr>
            <tr>
                <td><label for="">Password</label></td>
                <td><input type="text" name="pass" id="pass"></td>
            </tr>
            <tr>
                <td><label for="">Confirm Password</label></td>
                <td><input type="text" name="con_pass" id="con_pass"></td>
            </tr>
            <tr style="text-align: center;">
                <td><button type="submit" onclick="register()">submit</button></td>
                <td><button type="reset">Reset</button></td>
            </tr>
        </table>
        <script>
            function register() {
                if (document.getElementById("pass").value == document.getElementById("con_pass").value) {
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                            if (this.responseText == 1) {
                                alert("สมัครสมาชิกสำเร็จ");
                                location.href = "Login.php";
                            } else {
                                alert(this.responseText);
                            }
                        }
                    }
                    fname = document.getElementById("fname");
                    nickname = document.getElementById("nickname");
                    pass = document.getElementById("pass");
                    xhttp.open("POST", "rest.php");
                    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                    xhttp.send("Register=''&name=" + fname.value + "&nickname=" + nickname.value + "&pass=" + pass.value);
                } else {
                    alert("รหัสผ่านไม่ตรงกัน");
                }
            }
        </script>
    </div>
</body>

</html>