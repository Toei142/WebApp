<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>

<body style="margin: 0;">
    <div class="navbar">
        <a href="product_list.php">หน้าแรก</a>
        <a href="orderDetails.php">ตระกร้าสินค้า</a>
        <a href="#contact" style="float: right;">ออกจากระบบ</a>
        <a href="#contact" style="float: right;"> เข้าสู่ระบบ</a>
    </div>

    <div class="container" style="margin-top: 100px; width: 30%;">

        <div class="card">
            <table>
                <tbody id="body">
                </tbody>
            </table>
        </div>
    </div>

    <script>
        showOrder();

        function showOrder() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                text = "";
                if (this.readyState == 4 && this.status == 200) {
                    arr = JSON.parse(this.responseText);
                    text = "<tr>"
                    text += "<th>รหัสใบสั่งชื่อ</th><th>รหัสลูกค้า</th><th>วันที่ซื้อ</th><th>สถานะ</th>"
                    text += "</tr>";
                    for (i = 0; i < arr[0].length; i++) {
                        for (j = 0; j < arr[0][i].length; j++) {
                            text += "<td>" + arr[0][i][j] + "</td>";
                        }
                    }
                    text = "<tr>" + text + "</tr>";

                    text += "<tr>"
                    text += "<th>ชื่อสินค้า</th><th>จำนวน</th><th>ราคา</th><th>ราคารวม</th>"
                    text += "</tr>";
                    total = 0;
                    console.log(arr[1]);
                    for (a = 0; a < arr[1].length; a++) {
                        text += "<tr>";
                        text += "<td>" + arr[1][a].name + "</td>";
                        text += "<td>" + arr[1][a].quantity + "</td>";
                        text += "<td>" + arr[1][a].unitPrice + "</td>";

                        text += "<td>" + arr[1][a].quantity * arr[1][a].unitPrice + "</td>";
                        text += "</tr>";
                        total += parseInt(arr[1][a].quantity * arr[1][a].unitPrice);
                    }
                    text += '<tr><td>ราคารวม</td><td>' + total + '</td></tr>';
                    text += '<tr><td><button class="button" style="width:100px" onclick="pay('+arr[0][0][0] +')">ชำระเงิน</button></td></tr>';
                    document.getElementById("body").innerHTML = text;
                }
            }
            xhttp.open("GET", "rest.php?showOrderByCustomerID", true);
            xhttp.send();
        }
        function pay(id){
            alert(id)
        }

    </script>
</body>

</html>