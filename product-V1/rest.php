<?php
include_once "db.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['productList'])) {
        echo json_encode(showProductList());
    } else if (isset($_GET['productByID'])) {
        echo json_encode(showProductByID($_GET['id']));
    } else if (isset($_GET['showOrderByCustomerID'])) {
        echo json_encode(showOder(1));
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insertProuct'])) {
        echo   json_encode(insertProduct());
    } else if (isset($_POST['addOrder'])) {
        echo json_encode(openOrder());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $message = array("status" => print_r($_GET['u_id']));
    echo json_encode($message);
} else {
    http_response_code(405);
}
function insertProduct()
{
    $path = $_FILES['img']['tmp_name'];
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $mydb = new db();
    $sql = "INSERT INTO `product`(`image`, `name`, `number`, `price`) 
    VALUES ('$base64','{$_POST['name']}',{$_POST['number']},{$_POST['price']})";
    return $mydb->exec($sql);
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
    return   $mydb->query("SELECT * FROM `product`", MYSQLI_ASSOC);
    $mydb->close();
}
function showOder($id)
{
    $mydb = new db();
    $result = $mydb->query("SELECT * FROM `orders` WHERE status =0 AND customerID=$id", MYSQLI_NUM);
    $result2 = $mydb->query("SELECT * FROM `orderdetails` WHERE `orderID`={$result[0][0]}", MYSQLI_NUM);
    return array("0" => $result, "1" => $result2);
}

function openOrder()
{
    $p_id = $_POST['id'];
    $p_qty = $_POST['qty'];
    $p_price = $_POST['price'];

    $db = new db();
    //เช็ครหัสลูกค่ามีบิลป่าว
    $sql = "SELECT orderID, status FROM orders WHERE customerID=1 order by orderID desc limit 1";
    $bill_result = $db->query($sql, MYSQLI_NUM);
    if (sizeof($bill_result) == 0) { //ไม่มีบิลให้สร้าง
        // insert new
        $sql = "INSERT INTO orders(orderID, customerID, status) SELECT MAX(orderID)+1,1,0 FROM orders";
        $result = $db->exec($sql);
        $sql = "INSERT INTO orderdetails(orderID, productId, quantity,unitPrice) SELECT MAX(orderID),{$p_id},{$p_qty},{$p_price} FROM orders";
        $result = $db->exec($sql);
    } else { //มีบิล
        // check [0][0] bill_id
        //       [0][1] bill_status
        if ($bill_result[0][1] == 0) { //บิลยังไม่ปิดรายการขาย
            //เช็คสินค่า
            $sql = "SELECT orderID, productId,quantity FROM orderdetails WHERE orderID='{$bill_result[0][0]}' and productId = {$p_id}";
            $result = $db->query($sql, MYSQLI_NUM);
            if (sizeof($result) == 0) { //ยังไม่ได้ซื้อให้เพิ่ม
                // add new product
                $sql = "INSERT INTO orderdetails(orderID, productId, quantity, unitPrice)VALUES ({$bill_result[0][0]}, {$p_id}, {$p_qty}, {$p_price})";
                $result = $db->exec($sql);
            } else { //ซื้อแล้วให้เพิ่มจำนวน
                // update current item
                $total = $p_qty + $result[0][2];
                $sql = "UPDATE orderdetails SET `quantity`='{$total}' WHERE productId = {$p_id} AND orderID={$bill_result[0][0]}";
                //  echo $sql;
                $result = $db->exec($sql);
            }
        } else { //บิลปิดรายการขายแล้วให้สร้างใหม่เพื่อซื้อสินค้า
            // insert new
            $sql = "INSERT INTO orders(orderID, customerID, status) SELECT MAX(orderID)+1,1,0 FROM orders";
            $result = $db->exec($sql);
            $sql = "INSERT INTO orderdetails(orderID, productId, quantity,unitPrice) SELECT MAX(orderID),{$p_id},{$p_qty},{$p_price} FROM orders";
            $result = $db->exec($sql);
        }
    }
    $db->close();
    return $bill_result;
}
