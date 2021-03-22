<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body onload="loadDoc()">
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
        function loadDoc() {
            document.getElementById("tbody").innerHTML = "";
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                // console.log(this.readyState + "," + this.status);
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    var text = "";
                    for (var i = 0; i < fileJson.length; i++) {
                        text += "<tr><td>" + fileJson[i].orderID + "</td><td>" + fileJson[i].date + "</td>";
                        text += "<td>  <a href='orderDetails.php?id=" + fileJson[i].orderID + "'><button>แสดง</button></a></td>";
                        text += "<td> <button onclick='select_id(" + fileJson[i].orderID + ")''>ลบ</button></td></tr>";
                        document.getElementById("tbody").innerHTML = text;
                    }
                }
            }
            xhttp.open("GET", "02 rest.php?order");
            xhttp.send();
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