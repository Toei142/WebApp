<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body onload="productList()">
    <div class="container">
        <div>
            <table>
                <tbody id="body">
                </tbody>
            </table>
        </div>
        <div id="product"></div>
    </div>
    <img src=" " height="" alt="">
    <script>
        let data;
        label = ['รหัสสินค้า', 'รูป', 'ชื่อ', 'จำนวน', 'ราคา'];

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
                        text += " <button onclick='addProduct(" + i + ")'>Add to Cart</button>";
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
                    alert(this.responseText);
                    showOrder();
                }
            }
            xhttp.open("POST", "rest.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("addOrder&id=" + data[id].productID + "&qty=" + qty.value + "&price=" + data[id].cost);
        }
        showOrder();

        function showOrder() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                text = "";
                if (this.readyState == 4 && this.status == 200) {
                    arr = JSON.parse(this.responseText);
                    console.log(arr);
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
                    text += "<th>รหัสใบสั่งชื่อ</th><th>รหัสสินค้า</th><th>จำนวน</th><th>ราคา</th>"
                    text += "</tr>";
                    for (a = 0; a < arr[1].length; a++) {
                        for (b = 0; b < arr[1][a].length; b++) {
                            text += "<td>" + arr[1][a][b] + "</td>";
                        }
                        text = "<tr>" + text + "</tr>";
                    }

                    document.getElementById("body").innerHTML = text;
                }
            }
            xhttp.open("GET", "rest.php?showOrderByCustomerID", true);
            xhttp.send();
        }
    </script>
</body>

</html>