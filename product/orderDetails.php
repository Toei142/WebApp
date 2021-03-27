<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <select name="" id="product" class="custom-select"> </select>
    <label for="">จำนวน</label>
    <input type="number" name="" id="number" value="1">
    <button onclick="addProduct()">เพิ่มสินค้า</button>
    <h1>รายละเอียดใบสั่งซื้อ</h1>
    <div style="height:20px;margin-bottom:20px;font-size: 20px;font-weight: bold;">
        รหัส:<input type="text" id="orderID" readonly>
    </div>

    <div class="tb">
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคาสินค้า</th>
                        <th>จำนวนที่ซื้อ</th>
                        <th>ราคาราม</th>
                        <th>ลบ</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody id="tbody"></tbody>
            </table>
        </div>

    </div>

    <button type="submit" class="button" onclick="pay()">ชำระเงิน</button>
    <script>
        showProduct();
        showProductByOrderID();
        var param = window.location.search.substr(4);
        document.getElementById("orderID").value = param;
        console.log(param);

        function showProduct() {
            document.getElementById("product").innerHTML = "";
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
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

        function showProductByOrderID() {
            const orderID = <?php echo $_GET['id']; ?>;
            document.getElementById("tbody").innerHTML = "";
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    var text = "";
                    let total = 0;
                    for (var i = 0; i < fileJson.length; i++) {
                        text += "<tr><td>" + fileJson[i].productId + "</td><td>" + fileJson[i].name + "</td>";
                        text += "<td>" + fileJson[i].price + "</td><td>" + fileJson[i].number + "</td>";
                        text += "<td>" + (fileJson[i].number * fileJson[i].price) + "</td>";
                        text += "<td> <button onclick='deleteProductByID(" + fileJson[i].productId + ")''>ลบ</button></td></tr>";
                        total += parseInt(fileJson[i].number * fileJson[i].price);
                    }
                    text += "<tr><td colspan='4' id='lbtotal'>ราคารวม</td><td colspan='2'><span id='total'></span><span id='lbb'>฿</span></td></tr>";
                    document.getElementById("tbody").innerHTML = text;
                    document.getElementById("total").innerHTML = total;
                }
            }
            xhttp.open("GET", "02 rest.php?productByOrderID=" + orderID);
            xhttp.send();
        }

        function addProduct() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    //  alert(this.responseText);
                    showProductByOrderID();
                }
            }
            oid = document.getElementById("orderID");
            pid = document.getElementById("product");
            num = document.getElementById("number");
            xhttp.open("POST", "02 rest.php", true);
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("insertProductInOrder=''&orderID=" + oid.value + "&productID=" + pid.value + "&number=" + num.value);
        }

        function deleteProductByID(id) {
            const orderID = <?php echo $_GET['id']; ?>;
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    showProductByOrderID();
                }
            }
            xhttp.open("DELETE", "02 rest.php?DeleteProductByID=''&orderID=" + orderID + "&productID=" + id);
            xhttp.send();
        }

        function pay() {
            location.href = "order.php";
        }
    </script>
</body>

</html>