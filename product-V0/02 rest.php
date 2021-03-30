<?php
include_once "01 db.php";
include_once "util.php";
$debug_mode = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    debug_text("GET METHOD Process....", $debug_mode);
    if (isset($_GET['order'])) {
        echo json_encode(show_order($debug_mode));
    } else  if (isset($_GET['product'])) {
        echo json_encode(show_product($debug_mode));
    } else  if (isset($_GET['productByOrderID'])) {
        echo json_encode(showProductByOrderID($debug_mode, $_GET['productByOrderID']));
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insertOrder'])) {
        echo insertOrder($debug_mode, $_POST['productId'], $_POST['number']);
    } else if (isset($_POST['insertProductInOrder'])) {
        // echo print_r($_POST);
        if (insertProductInOrder($debug_mode, $_POST['orderID'], $_POST['productID'], $_POST['number'])) {
            echo "เพิ่มสำเร็จ";
        } else {
            echo "เพิ่มสินค่าสำเร็จ";
            updateProductInOrder($debug_mode, $_POST['orderID'], $_POST['productID'], $_POST['number']);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // $message = array("status" => print_r($_GET));
    // echo json_encode($message);
    if (isset($_GET['DeleteOrderByID'])) {
        deleteOrderByID($debug_mode, $_GET['DeleteOrderByID']);
    } else if (isset($_GET['DeleteProductByID'])) {
        deleteProductByID($debug_mode, $_GET['orderID'], $_GET['productID']);
    }
} else {
    debug_text("Error this site Unsupport This request", $debug_mode);
    http_response_code(405);
}
function show_order($debug_mode)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $data = $mydb->query("SELECT * FROM `orders`");
    $mydb->close();
    return $data;
}
function show_product($debug_mode)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $data = $mydb->query("SELECT * FROM `product`");
    return $data;
    $mydb->close();
}
function showProductByOrderID($debug_mode, $id)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $data = $mydb->query("SELECT orderdetails.productId,product.name,orderdetails.number,product.price FROM orderdetails,product WHERE orderdetails.productId=product.productID AND orderdetails.orderID=$id");
    return $data;
    $mydb->close();
}
function insertOrder($debug_mode, $id, $num)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $mydb->deleteUpdate("INSERT INTO `orders`(`orderID`, `date`) VALUES (null,null)");
    $mydb->deleteUpdate("INSERT INTO orderdetails SELECT MAX(orderID),$id,$num FROM orders");
    $result = $mydb->query("SELECT MAX(orderID) as max FROM orders");
    return $result[0]['max'];
    $mydb->close();
}
function insertProductInOrder($debug_mode, $OID, $PID, $num)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    return $mydb->deleteUpdate("INSERT INTO `orderdetails`VALUES ($OID,$PID,$num)");
    $mydb->close();
}
function updateProductInOrder($debug_mode, $OID, $PID, $num)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $result = $mydb->query("SELECT * FROM `orderdetails` WHERE `orderID`=$OID AND `productId`=$PID");
    $value = $result[0]['number'] + $num;
    $mydb->deleteUpdate("UPDATE `orderdetails` SET `number`=$value WHERE `orderID`=$OID AND productId=$PID");
    $mydb->close();
}
function deleteOrderByID($debug_mode, $id)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $mydb->deleteUpdate("DELETE orders,orderdetails FROM orders INNER JOIN orderdetails ON orders.orderID=orderdetails.orderID WHERE orders.orderID={$id}");
    $mydb->close();
}
function deleteProductByID($debug_mode, $OID, $PID)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $mydb->deleteUpdate("DELETE FROM `orderdetails` WHERE `orderID`=$OID AND `productId`=$PID");
    $mydb->close();
}
