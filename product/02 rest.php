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
    } else  if (isset($_GET['productID'])) {
        echo json_encode(showProductByOrderID($debug_mode, $_GET['productID']));
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    debug_text("POST METHOD May be implement soon.....", $debug_mode);
    $message = array("status" => print_r($_POST));
    echo json_encode($message);
    if (isset($_POST['insertOder'])) {
        insert_order($debug_mode, $_POST['productId'], $_POST['number']);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // debug_text("DELETE METHOD.....", $debug_mode);
    // delete_id($debug_mode, $_GET['u_id']);
    $message = array("status" => print_r($_GET['DeleteOrderByID']));
    echo json_encode($message);
    if (isset($_GET['DeleteOrderByID'])) {
        deleteOrderByID($debug_mode, $_GET['DeleteOrderByID']);
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
function insert_order($debug_mode, $id, $num)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $mydb->deleteUpdate("INSERT INTO `orders`(`orderID`, `date`) VALUES (null,null)");
    $mydb->deleteUpdate("INSERT INTO orderdetails SELECT MAX(orderID),$id,$num FROM orders");
    $mydb->close();
}
function deleteOrderByID($debug_mode, $id)
{
    $mydb = new db("root", "", "itishop", $debug_mode);
    $mydb->deleteUpdate("DELETE orders,orderdetails FROM orders INNER JOIN orderdetails ON orders.orderID=orderdetails.orderID WHERE orders.orderID={$id}");
    $mydb->close();
}
