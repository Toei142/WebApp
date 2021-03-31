<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>

<body onload="productList()" style="margin: 0;">
    <div class="navbar">
        <a href="product_list.php">หน้าแรก</a>
        <a href="orderDetails.php">ตระกร้าสินค้า</a>
        <a href="#contact" style="float: right;">ออกจากระบบ</a>
        <a href="#contact" style="float: right;"> เข้าสู่ระบบ</a>
    </div>


    <div class="container" style="margin-top: 70px;">

        <div>
            <table style="background-color:;">
                <tbody id="body">
                </tbody>
            </table>
        </div>
        <div id="product"></div>
    </div>
    <img src=" " height="" alt="">
    <script>
        let data;

        function productList() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                text = "";
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    text += "<div class='row'>";
                    for (i = 0; i < data.length; i++) {
                        text += "<div class='column'>";
                        text += "<div class='card'>";
                        text += "<img src='" + data[i].image + "' width='5%' height='5%'><br>";
                        text += data[i].name + "<br>";
                        text += "฿ " + data[i].cost + " <input type='number' name='' id='n" + i + "' size='4' max='" + data[i].stock + "' min='1' value='1'>";
                        text += " <button class='button2' style='vertical-align:middle' onclick='addProduct(" + i + ")'><span>เพิ่มไปยังรถเข็น</span></button>";
                        text += "</div>";
                        text += "</div>";
                    }
                    text += "</div>";
                    document.getElementById("product").innerHTML = text;

                }
            }
            xhttp.open("GET", "rest.php?productList", true);
            xhttp.send();
        }

        function addProduct(id) {
            qty = document.getElementById("n" + id);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == 1) {
                        alert("เพิ่มสำเร็จ");
                    } else alert("เพิ่มสินค้าไม่สำเร็จ");
                    showOrder();
                }
            }
            xhttp.open("POST", "rest.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("addOrder&id=" + data[id].productID + "&qty=" + qty.value + "&price=" + data[id].cost);
        }
    </script>
</body>

</html>