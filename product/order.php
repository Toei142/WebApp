<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="showOrderAll()">
    <h1>ขายสินค้า</h1>
    <select name="" id="product"> </select>
    <label for="">จำนวน</label>
    <input type="number" name="" id="number" value="1">
    <a href=""><button onclick="addOrder()">เพิ่มใบสั่งซื้อ</button></a>
    <h1>รายการขาย</h1>
    <table>
        <thead>
            <tr>
                <th>รหัส</th>
                <th>วันที่ชื้อ</th>
                <th>รายละเอียด</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
    <script>
        function showOrderAll() {
            document.getElementById("tbody").innerHTML = "";
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    var text = "";
                    for (var i = 0; i < fileJson.length; i++) {
                        text += "<tr><td>" + fileJson[i].orderID + "</td><td>" + fileJson[i].date + "</td>";
                        text += "<td>  <a href='orderDetails.php?id=" + fileJson[i].orderID + "'><button>แสดง</button></a></td>";
                        text += "<td> <button onclick='deleteOrderByID(" + fileJson[i].orderID + ")''>ลบ</button></td></tr>";
                        document.getElementById("tbody").innerHTML = text;
                    }
                }
            }
            xhttp.open("GET", "02 rest.php?order");
            xhttp.send();
        }
        showProduct();

        function showProduct() {
            document.getElementById("product").innerHTML = "";
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // console.log(this.readyState + "," + this.status);
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    var text = "";
                    for (var i = 0; i < fileJson.length; i++) {
                        text += '<option value="' + fileJson[i].productID + '">' + fileJson[i].name + '</option>';
                        document.getElementById("product").innerHTML = text;
                    }
                }
            }
            xhttp.open("GET", "02 rest.php?product");
            xhttp.send();
        }

        function addOrder() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    location.href = "orderDetails.php?id=" + this.responseText;
                }
            }
            pid = document.getElementById("product");
            num = document.getElementById("number");
            xhttp.open("POST", "02 rest.php", true);
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("insertOrder=''&productId=" + pid.value + "&number=" + num.value);
        }

        function deleteOrderByID(id) {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    showOrderAll();
                }
            }
            xhttp.open("DELETE", "02 rest.php?DeleteOrderByID=" + id);
            xhttp.send();
        }
    </script>
</body>

</html>