<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once "Verified.php" ?>
</head>

<body>
    <div>
        <div style="text-align: center;">
            <a href="">สั่งซื้อสินค้า</a> <a href="">ชำระเงิน</a> <a href="Logout.php">ออกจากระบบ</a>
        </div>
        <div style="text-align: right;">
            <h3>
                <?php
                echo  "ยินดีต้อนรับ<br>คุณ" . $_SESSION['name'];
                ?>
            </h3>
        </div>

        <h1 style="text-align: center;">SHOPSHOCK</h1>
        <table style='margin-left: auto;margin-right: auto;'>
            <tbody id="tbody"></tbody>
        </table>
    </div>

    <script>
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                let fileJson = JSON.parse(this.responseText);
                var text = "";
                console.log(fileJson);
                for (var i = 0; i < fileJson.length; i++) {
                    text += "<tr>";
                    text += "<td>" + fileJson[i].Product_id + "</td>";
                    text += "<td>" + fileJson[i].Product_code + "</td>";
                    text += "<td>" + fileJson[i].Product_Name + "</td>";
                    text += "<td>" + fileJson[i].Brand_name + "</td>";
                    text += "<td>" + fileJson[i].Unit_name + "</td>";
                    text += "<td>" + fileJson[i].Cost + "</td>";
                    text += "<td><a href='Add_Product.php?id=" + fileJson[i].Product_id + "'><'Shop Shock'></a></td>";
                    text += "</tr>";
                    document.getElementById("tbody").innerHTML = text;
                }
            }
        }
        xhttp.open("GET", "rest.php?productlist");
        xhttp.send();
    </script>
</body>

</html>