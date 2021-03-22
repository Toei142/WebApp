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
    //$message = array("status" => print_r($_POST));
    add_data($debug_mode, $_POST['u_name'], $_POST['u_age']);
    echo json_encode($message);
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    debug_text("DELETE METHOD.....", $debug_mode);
    delete_id($debug_mode, $_GET['u_id']);
    $message = array("status" => print_r($_GET['u_id']));
    echo json_encode($message);
} else {
    debug_text("Error this site Unsupport This request", $debug_mode);
    http_response_code(405);
}
function show_order($debug_mode)
{
    $mydb = new db("root", "", "product", $debug_mode);
    $data = $mydb->query("SELECT * FROM `order`");
    $mydb->close();
    return $data;
}
function show_product($debug_mode)
{
    $mydb = new db("root", "", "product", $debug_mode);
    $data = $mydb->query("SELECT * FROM `product`");
    return $data;
    $mydb->close();
}
function showProductByOrderID($debug_mode, $id)
{
    $mydb = new db("root", "", "product", $debug_mode);
    $data = $mydb->query("SELECT orderdetails.productId,product.name,orderdetails.number,product.price FROM orderdetails,product WHERE orderdetails.productId=product.productID AND orderdetails.orderID=$id");
    return $data;
    $mydb->close();
}
function insert_order($debug_mode)
{
    $mydb = new db("root", "", "product", $debug_mode);
    $mydb->query("INSERT INTO `order`(`orderID`, `date`) VALUES (null,null)");
    $mydb->close();
}
function add_data($debug_mode, $name, $age)
{
    $mydb = new db("root", "", "product", $debug_mode);
    $mydb->query("INSERT INTO `person`(`name`, `age`) VALUES ('$name',$age)");
    $mydb->close();
}
function delete_id($debug_mode, $id)
{
    $mydb = new db("root", "", "product", $debug_mode);
    $mydb->query("DELETE FROM orderdetails WHERE id=$id");
    $mydb->close();
}
