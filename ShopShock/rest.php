<?php
include_once "db.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['productList'])) {
        echo json_encode(showProductList());
    } else if (isset($_GET['productByID'])) {
        echo json_encode(showProductByID($_GET['id']));
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Register'])) {
        if (insertMember($_POST['name'], $_POST['nickname'], $_POST['pass'])) {
            echo 1;
        } else echo 0;
    } else if (isset($_POST['login'])) {
        if (login($_POST['username'], $_POST['password'])) {
            echo 1;
        } else echo 0;
    } else if (isset($_POST['openBill'])) {
        if (open_bill()) {
            echo 1;
        } else echo 0;
        // echo json_encode(open_bill());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $message = array("status" => print_r($_GET['u_id']));
    echo json_encode($message);
} else {
    http_response_code(405);
}

function insertMember($name, $user, $password)
{
    $mydb = new db();
    return  $mydb->exec("INSERT INTO `member`SELECT MAX(member_id)+1,'{$name}','{$user}','{$password}','01' FROM member");
    $mydb->close();
}


function login($user, $pass)
{
    $mydb = new db();
    $data = $mydb->query("SELECT * FROM `member` WHERE `user`='{$user}' AND `password`='{$pass}'");
    if ($data != null) {
        $_SESSION['cus_id'] = 1;
        return $data;
    }
    $mydb->close();
}

function showProductList()
{
    $mydb = new db();
    return $mydb->query("SELECT product.Product_id,product.Product_code,product.Product_Name,brand.Brand_name,unit.Unit_name,product.Cost FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id");
    $mydb->close();
}
function showProductByID($id)
{
    $mydb = new db();
    return $mydb->query("SELECT product.*,unit.*,brand.* FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id AND product.Product_id=$id");
}

function open_bill()
{
    $p_id = $_POST['p_id'];
    $p_qty = $_POST['p_qty'];
    $p_price = $_POST['p_price'];
    $db = new db();
    //เช็ครหัสลูกค่ามีบิลป่าว
    $sql = "SELECT Bill_id, Bill_status FROM bill WHERE Cus_ID='{$_SESSION['cus_id']}' order by Bill_id desc limit 1";
    $bill_result = $db->query($sql);
    if (sizeof($bill_result) == 0) { //ไม่มีบิลให้สร้าง
        // insert new
        $sql = "INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) SELECT MAX(Bill_id)+1,'{$_SESSION['cus_id']}',0 FROM bill";
        $result = $db->exec($sql);
        $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) SELECT MAX(Bill_id), '{$p_id}', '{$p_qty}', '{$p_price}' FROM bill";
        $result = $db->exec($sql);
    } else { //มีบิล
        // check [0][0] bill_id
        //       [0][1] bill_status
        if ($bill_result[0][1] == 0) { //บิลยังไม่ปิดรายการขาย
            //เช็คสินค่า
            $sql = "SELECT Bill_id, Product_ID,Quantity FROM bill_detail WHERE Bill_id='{$bill_result[0][0]}' and Product_ID = {$p_id}";
            $result = $db->query($sql);
            if (sizeof($result) == 0) { //ยังไม่ได้ซื้อให้เพิ่ม
                // add new product
                $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price)
                        VALUES ({$bill_result[0][0]}, {$p_id}, {$p_qty}, {$p_price})";
                $result = $db->exec($sql);
            } else { //ซื้อแล้วให้เพิ่มจำนวน
                // update current item
                $total = $p_qty + $result[0][2];
                $sql = "UPDATE `bill_detail` SET `Quantity`='{$total}' WHERE Product_ID = {$p_id} AND Bill_id={$bill_result[0][0]}";
                //  echo $sql;
                $result = $db->exec($sql);
            }
        } else { //บิลปิดรายการขายแล้วให้สร้างใหม่เพื่อซื้อสินค้า
            // insert new
            $sql = "INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) SELECT MAX(Bill_id)+1,'{$_SESSION['cus_id']}',0 FROM bill";
            $result = $db->exec($sql);
            $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) SELECT MAX(Bill_id), '{$p_id}', '{$p_qty}', '{$p_price}' FROM bill";
            $result = $db->exec($sql);
        }
    }
    $db->close();
    return $bill_result;
}
