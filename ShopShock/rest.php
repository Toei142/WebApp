<?php
include_once "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['productlist'])) {
        echo json_encode(showProductList());
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
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    delete_id($_GET['u_id']);
    $message = array("status" => print_r($_GET['u_id']));
    echo json_encode($message);
} else {
    http_response_code(405);
}

function insertMember($name, $user, $password)
{
    $mydb = new db("root", "", "shopshock");
    $data =  $mydb->CUD("INSERT INTO `member`SELECT MAX(member_id)+1,'{$name}','{$user}','{$password}','01' FROM member");
    return $data;
    $mydb->close();
}
function login($user, $pass)
{
    $mydb = new db("root", "", "shopshock");
    $data = $mydb->query("SELECT * FROM `member` WHERE `user`='{$user}' AND `password`='{$pass}'");
    session_start();
    if ($data != null) {
        $_SESSION['member_id'] = $data[0]['member_id'];
        $_SESSION['name'] = $data[0]['name'];
        return $data;
    }
    $mydb->close();
}

function showProductList()
{
    $mydb = new db("root", "", "shopshock");
    $data = $mydb->query("SELECT product.Product_id,product.Product_code,product.Product_Name,brand.Brand_name,unit.Unit_name,product.Cost FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id");
    $mydb->close();
    return $data;
}




function showProductByID($id)
{
    $mydb = new db("root", "", "shopshock");
    $data = $mydb->CUD("SELECT product.*,unit.*,brand.* FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id AND product.Product_id=$id");
    return $data->fetch_assoc();
}

function show_data()
{
    $mydb = new db("root", "", "person_data");
    $data = $mydb->query("select * from person");
    $mydb->close();
    return $data;
}
function add_data($name, $age)
{
    $mydb = new db("root", "", "person_data");
    $mydb->query("INSERT INTO `person`(`name`, `age`) VALUES ('$name',$age)");
    $mydb->close();
}
function delete_id($id)
{
    $mydb = new db("root", "", "person_data");
    $mydb->query("DELETE FROM person WHERE id=$id");
    $mydb->close();
}
