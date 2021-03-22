<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>รายละเอียดใบสั่งซื้อ</h1>
    <table>
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
        <tbody id="tbody">
        </tbody>
    </table>
    <script>
        showProductByOrderID();

        function showProductByOrderID() {
            const oderID = <?php echo $_GET['id']; ?>;
            document.getElementById("tbody").innerHTML = "";
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    var text = "";
                    for (var i = 0; i < fileJson.length; i++) {
                        text += "<tr><td>" + fileJson[i].productId + "</td><td>" + fileJson[i].name + "</td>";
                        text += "<td>" + fileJson[i].price + "</td><td>" + fileJson[i].number + "</td><td>" + (fileJson[i].number * fileJson[i].price) + "</td>";
                        text += "<td> <button onclick='deleteProductByID(" + fileJson[i].productId + ")''>ลบ</button></td></tr>";
                        document.getElementById("tbody").innerHTML = text;
                    }
                }
            }
            xhttp.open("GET", "02 rest.php?productID=" + oderID);
            xhttp.send();
        }

        function deleteProductByID(id) {
            const oderID = <?php echo $_GET['id']; ?>;
            alert("ยังไม่ได้ทำลบ" + oderID + " " + id);
        }

        function add_new() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    loadDoc();
                }
            }
            n = document.getElementById("u_name");
            a = document.getElementById("u_age");
            xhttp.open("POST", "02 rest.php", true);
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send("u_name=" + n.value + "&u_age=" + a.value);
            a.value = "";
            n.value = "";

        }

        function delete_id(id) {
            console.log("u_id=" + id);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    loadDoc();
                }
            }
            xhttp.open("DELETE", "02 rest.php?u_id=" + id, true);
            xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xhttp.send();
        }
    </script>
</body>

</html>