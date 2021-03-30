<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php// include_once "Verified.php" ?>
</head>

<body>
    <div>
        <div style="text-align: center;">
            <a href="">สั่งซื้อสินค้า</a> <a href="">ชำระเงิน</a> <a href="Logout.php">ออกจากระบบ</a>
        </div>
        <div style="text-align: right;">
            <h3>
                <?php
                //echo  "ยินดีต้อนรับ<br>คุณ" . $_SESSION['name'];
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
                    text += "<td><a href='Add_Product.php?id=" + fileJson[i].Product_id + "'>Shop Shock</a></td>";
                    text += "</tr>";
                    document.getElementById("tbody").innerHTML = text;
                }
            }
        }
        xhttp.open("GET", "rest.php?productList");
        xhttp.send();
    </script>
</body>

</html> -->


<?php
session_start();
$_SESSION['cus_id'] = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="load_doc()">
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
    <center>
        <div id="out"></div>
        <br>
        <div id="out2"></div>
    </center>
    <script>
        let arr;
        let cus_id = <?= $_SESSION['cus_id'] ?>;
        label = ['item id', 'product code', 'product name', 'brand', 'หน่วยนับ', 'ราคาขาย', 'จำนวนสินค้าที่ต้องการ'];

        function load_doc() {
            out = document.getElementById("out");
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    arr = JSON.parse(this.responseText);
                    text = "<table border='1'>";
                    for (i = 0; i < label.length - 1; i++) {
                        text += "<th>" + label[i] + "</th>";
                    }
                    text = "<tr>" + text + "</tr>";
                    for (i = 0; i < arr.length; i++) {
                        for (j = 0; j < arr[i].length; j++) {
                            text += "<td>" + arr[i][j] + "</td>";
                        }
                        text += "<td>" + "<button onclick='sel_product(" + i + ")'>< ShopShock ></button>" + "</td>";
                        text = "<tr>" + text + "</tr>";
                    }

                    text += "</table>";
                    out.innerHTML = text;
                }
            }
            xhttp.open("GET", "rest.php?productList", true);
            xhttp.send();
        }

        function sel_product(idx) {
            out = document.getElementById("out2");
            text = "";
            text += "<table border='1'>";
            for (i = 0; i < label.length - 1; i++) {
                text += "<tr><td>" + label[i] + "</td>";
                text += "<td>" + arr[idx][i] + "</td></tr>";
            }
            text += "<tr><td>" + label[6] + "</td>";
            text += "<td><input type='number' id='n" + idx + "' min='1' max='" + arr[idx][6] + "'></td></tr>";
            text += "<tr><td colspan='2'><button onclick='open_po(" + idx + "," + cus_id + ")'>add to cart</button><input type='reset'></td></tr>"
            text += "</table>";
            out.innerHTML = text;
        }

        function open_po(idx, cus_id) {
            qty = document.getElementById("n" + idx);
            //alert("product_code=" + arr[idx][1] + ":value=" + qty.value);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            }
            xhttp.open("POST", "rest.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("bill&p_id=" + arr[idx][0] + "&p_qty=" + qty.value + "&cus_id=" + cus_id);
        }
    </script>
</body>

</html>