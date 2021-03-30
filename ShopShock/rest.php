<?php
include_once "db.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['productList'])) {
        echo json_encode(showProductList());
    } else if (isset($_GET['productByID'])) {
        echo json_encode(showProductByID($_GET['id']));
    } else if (isset($_GET['billByID'])) {
        echo json_encode(showBill());
    } else if (isset($_GET['billDetailByBillID'])) {
        if (openBill()) {
            echo json_encode(showBill());
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Register'])) {
        if (insertMember($_POST['name'], $_POST['nickname'], $_POST['pass'])) {
            echo 1;
        } else echo "สมัครสมาชิกไม่สำเร็จ";
    } else if (isset($_POST['login'])) {
        if (login($_POST['username'], $_POST['password'])) {
            echo 1;
        } else echo "รหัสผ่านผิด";
    } else if (isset($_POST['insertBill'])) {
        if (insertBill($_POST['pid'], $_POST['qtt'], $_POST['price'])) {
            echo 1;
        } else echo "ERROR";
    } else if (isset($_POST['bill'])) {
        //  session_start();
        //   echo print_r($_SESSION);
        echo print_r($_POST);
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
    return  $mydb->CUD("INSERT INTO `member`SELECT MAX(member_id)+1,'{$name}','{$user}','{$password}','01' FROM member");
    $mydb->close();
}


function login($user, $pass)
{
    $mydb = new db();
    $data = $mydb->query("SELECT * FROM `member` WHERE `user`='{$user}' AND `password`='{$pass}'");
    // session_start();
    if ($data != null) {
        $_SESSION['cus_id'] = $data[0]['member_id'];
        $_SESSION['name'] = $data[0]['name'];
        return $data;
    }
    $mydb->close();
}

function showProductList()
{
    $mydb = new db();
    return $mydb->queryNUM("SELECT product.Product_id,product.Product_code,product.Product_Name,brand.Brand_name,unit.Unit_name,product.Cost FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id");
    $mydb->close();
}
function showProductByID($id)
{
    $mydb = new db();
    return $mydb->query("SELECT product.*,unit.*,brand.* FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id AND product.Product_id=$id");
}

function openBill()
{
    $mydb = new db();
    $sql = "SELECT Bill_id,Bill_status FROM bill WHERE Cus_ID='{$_SESSION['cus_id']}' ORDER by Bill_id DESC LIMIT 1";
    $result = $mydb->queryNUM($sql);
    if (sizeof($result) == 0) {
        $sql = "INSERT INTO `bill`(`Bill_id`, `Cus_ID`, `Bill_Status`) VALUES (1,'{$_SESSION['cus_id']}',0)";
        $mydb->CUD($sql);
        $sql = "INSERT INTO `bill_detail`(`Bill_id`, `Product_ID`, `Quantity`, `Unit_Price`) VALUES (1,'{$_POST['p_id']}','{$_POST['p_qty']}','{$_POST['p_price']}')";
        $mydb->CUD($sql);
    } else {
        if($result[1]==0){
            $sql="SELECT Bill_id,Product_ID FROM bill_detail WHERE Bill_id ='{$_SESSION['cus_id']}' and Product_ID='{$_POST['p_id']}'";
            $result =$mydb->query($sql);
            if(sizeof($result)==0){
                $sql="";
            }
        }
    }
    return $result;
}

function showBill()
{
    $mydb = new db();
    $data = $mydb->query("SELECT * FROM `bill` WHERE 1");
    return $data;
    $mydb->close();
}
function showBillDetail()
{
    $mydb = new db();
    $data = $mydb->query("SELECT * FROM `bill_detail` WHERE 1");
    return $data;
    $mydb->close();
}

function insertBill($pid, $qtt, $price)
{
    $mydb = new db();
    $mydb->CUD("INSERT INTO `bill` SELECT MAX(Bill_id)+1,null,null,null,0,null FROM bill");
    $data = $mydb->CUD("INSERT INTO `bill_detail` SELECT MAX(Bill_id),$pid,$qtt,$price FROM bill");
    return $data;
    $mydb->close();
}
