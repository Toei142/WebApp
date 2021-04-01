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
    <center>
        <a href="logOut.php">ออกจากระบบ</a>
        <div id="out"></div>
        <br>
        <div id="out2"></div>
        <div id="out3"></div>
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
                        for (j = 0; j < arr[i].length - 1; j++) {
                            text += "<td>" + arr[i][j] + "</td>";
                        }
                        text += "<td>" + "<button onclick='sel_product(" + i + ")'>< ShopShock ></button>" + "<td>";
                        text = "<tr>" + text + "</tr>";
                    }

                    text += "</table>";
                    out.innerHTML = text;
                }
            }
            xhttp.open("GET", "product_rest.php", true);
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
            text += "<tr><td colspan='2'><button onclick='open_bill(" + idx + "," + cus_id + ")'>add to cart</button><input type='reset'></td></tr>"
            text += "</table>";
            out.innerHTML = text;
        }

        function open_bill(idx, cus_id) {
            out = document.getElementById("out2");
            qty = document.getElementById("n" + idx);
            price = arr[idx][5];
            //alert("product_code="+arr[idx][1]+"="+qty.value+",price"+price);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    arr2 = JSON.parse(this.responseText);
                    t1 = arr2["bill"][0];
                    console.log(t1);
                    text = "<table border='1'><tr>";
                    text += "<tr><th>Bill Id</th><th>CUS_ID</th><th>EmpID</th><th>Bill Date</th><th>Bill Status</th><th>Remask</th></tr>";
                    for (i = 0; i < t1.length; i++) {
                        text += "<td>" + t1[i] + "</td>";
                    }
                    text += "</tr></table>";
                    out3.innerHTML = text;
                    text += "<tr>" + text + "</tr>";
                    for (i = 0; i < arr.length; i++) {
                        for (j = 0; j < arr[i].length - 1; j++) {
                            text += "<td>" + arr[i][j] + "</td>";
                        }
                        text += "<td><button onclick='sel_product" + i + "'></button></td>";
                        text = "<tr>" + text + "</tr>";
                    }
                    text += "</table>";

                }
            }
            xhttp.open("POST", "product_rest.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("p_id=" + arr[idx][0] + "&p_qty=" + qty.value + "&p_price=" + price + "&cus_id=" + cus_id);
        }
    </script>
</body>

</html>