<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="margin: 0 auto; width:50%">
        <table border="1">
            <thead>
                <th>Bill_ID</th>
                <th>Cus_ID</th>
                <th>Emp_ID</th>
                <th>Bill_Date</th>
                <th>Bill_Status</th>
                <th> </th>
            </thead>
            <tbody id="tbody"></tbody>
            <table>
                <thead>
                    <th>No.</th>
                    <th>Product_Code</th>
                    <th>Product_Name</th>
                    <th>Quantity</th>
                    <th>Unit_Price</th>
                    <th>Total</th>
                </thead>
                <tbody id="detail"></tbody>
            </table>
        </table>
    </div>
    <script>
        showBill();
        showBillDetail();

        function showBill() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    //   console.log(fileJson);
                    var text = "";
                    for (var i = 0; i < fileJson.length; i++) {
                        text += "<tr>";
                        text += "<td>" + (i + 1) + "</td>";
                        text += "<td>" + fileJson[i].Cus_ID + "</td>";
                        text += "<td>" + fileJson[i].Emp_id + "</td>";
                        text += "<td>" + fileJson[i].Bill_Date + "</td>";
                        text += "<td>" + fileJson[i].Bill_Status + "</td>";
                        text += "<td>Paid</td>";
                        text += "</tr>";
                        document.getElementById("tbody").innerHTML = text;
                    }
                }
            }
            xhttp.open("GET", "rest.php?billByID");
            xhttp.send();
        }

        function showBillDetail() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                    let fileJson = JSON.parse(this.responseText);
                    console.log(fileJson);
                    var text = "";
                    for (var i = 0; i < fileJson.length; i++) {
                        text += "<tr>";
                        text += "<td>" + (i + 1) + "</td>";
                        text += "<td>" + fileJson[i].Product_ID + "</td>";
                        text += "<td>" + fileJson[i].Product_Name + "</td>";
                        text += "<td>" + fileJson[i].Quantity + "</td>";
                        text += "<td>" + fileJson[i].Unit_Price + "</td>";
                        text += "<td>" + (fileJson[i].Quantity + fileJson[i].Unit_Price) + "</td>";
                        text += "</tr>";
                        document.getElementById("detail").innerHTML = text;
                    }
                }
            }
            xhttp.open("GET", "rest.php?billDetailByBillID");
            xhttp.send();
        }
    </script>
</body>

</html>