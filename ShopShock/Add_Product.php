<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
require_once "Verified.php";
?>

<body style="margin: 0 auto; width:50%">
    <H1>SHOPSHOCK</H1>
    <h3>Select Product to Cart</h3>
    <div style="border:red 1px solid;padding:20px">
        <hr>
        <table>
            <tr>
                <td>Product_ID</td>
                <td><input type="text" name="" id="Product_ID" readonly></td>
            </tr>
            <tr>
                <td>Product_Code</td>
                <td><input type="text" name="" id="Product_Code" readonly></td>
            </tr>
            <tr>
                <td>Product_Name</td>
                <td><input type="text" name="" id="Product_Name" readonly></td>
            </tr>
            <tr>
                <td>Brand</td>
                <td><input type="text" name="" id="Brand" readonly></td>
            </tr>
            <tr>
                <td>Unit</td>
                <td><input type="text" name="" id="Unit" readonly></td>
            </tr>
            <tr>
                <td>Cost</td>
                <td><input type="text" name="" id="Cost" readonly></td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><input type="number" name="" id="Quantity" required></td>
            </tr>
        </table>
        <hr>
        <div style="text-align: center;"><button type="submit">Submit</button> <button type="reset">Reset</button></div>
    </div>
    <script>
        var param = window.location.search.substr(4);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) { //เช็คการเชื่่อมต่อ
                let fileJson = JSON.parse(this.responseText);
                console.log(fileJson);
                for (var i = 0; i < fileJson.length; i++) {
                    document.getElementById("Product_ID").value = fileJson[i].Product_id;
                    document.getElementById("Product_Code").value = fileJson[i].Product_code;
                    document.getElementById("Product_Name").value = fileJson[i].Product_Name;
                    document.getElementById("Brand").value = fileJson[i].Brand_name;
                    document.getElementById("Unit").value = fileJson[i].Unit_name;
                    document.getElementById("Cost").value = fileJson[i].Cost;
                    document.getElementById("Quantity").value = fileJson[i].Stock_Quantity;
                }
            }
        }
        xhttp.open("GET", "rest.php?productByID&id=" + param);
        xhttp.send();
    </script>
</body>

</html>