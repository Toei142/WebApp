<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
require_once "rest.php";
$rs = showProductByID($_GET['id']);
print_r($rs);
?>

<body style="margin: 0 auto; width:50%">
    <H1>SHOPSHOCK</H1>
    <h3>Select Product to Cart</h3>
    <div style="border:red 1px solid;padding:20px">
        <hr>
        <table>
            <tr>
                <td>Product_ID</td>
                <td><input type="text" name="" id="" value="<?= $rs['Product_id'] ?>"></td>
            </tr>
            <tr>
                <td>Product_Code</td>
                <td><input type="text" name="" id="" value="<?= $rs['Product_code'] ?>"></td>
            </tr>
            <tr>
                <td>Product_Name</td>
                <td><input type="text" name="" id="" value="<?= $rs['Product_Name'] ?>"></td>
            </tr>
            <tr>
                <td>Brand</td>
                <td><input type="text" name="" id="" value="<?= $rs['Brand_name'] ?>"></td>
            </tr>
            <tr>
                <td>Unit</td>
                <td><input type="text" name="" id="" value="<?= $rs['Unit_name'] ?>"></td>
            </tr>
            <tr>
                <td>Cost</td>
                <td><input type="text" name="" id="" value="<?= $rs['Cost'] ?>"></td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td><input type="number" name="" id="" value="<?= $rs['Stock_Quantity'] ?>"></td>
            </tr>
        </table>
        <hr>
        <div style="text-align: center;"><button type="submit">Submit</button> <button type="reset">Reset</button></div>
    </div>
</body>

</html>