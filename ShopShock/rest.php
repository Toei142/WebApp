<?php
include_once "db.php";
$debug_mode = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['productlist'])) {
        show_productList($debug_mode);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Register'])) {
        insertMember($debug_mode, $_POST['name'], $_POST['nickname'], $_POST['pass']);
        header('Location:Login.php');
    } else if (isset($_POST['login'])) {
        if (login($debug_mode, $_POST['username'], $_POST['password'])) {
            header('Location:ProductList.php');
        } else echo "รหัสผ่านผิด";
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    delete_id($debug_mode, $_GET['u_id']);
    $message = array("status" => print_r($_GET['u_id']));
    echo json_encode($message);
} else {
    debug_text("Error this site Unsupport This request", $debug_mode);
}

function insertMember($debug_mode, $name, $user, $password)
{
    $mydb = new db("root", "", "shopshock", $debug_mode);
    $mydb->queryE("INSERT INTO `member`SELECT MAX(member_id)+1,'{$name}','{$user}','{$password}','01' FROM member");
    $mydb->close();
}
function login($debug_mode, $user, $pass)
{
    $mydb = new db("root", "", "shopshock", $debug_mode);
    $data = $mydb->query("SELECT * FROM `member` WHERE `user`='{$user}' AND `password`='{$pass}'");
    session_start();
    if ($data != null) {
        $_SESSION['member_id'] = $data[0]['member_id'];
        $_SESSION['name'] = $data[0]['name'];
        return $data;
    }
    $mydb->close();
}

function show_productList($debug_mode)
{
    $mydb = new db("root", "", "shopshock", $debug_mode);
    $data = $mydb->queryE("SELECT product.Product_id,product.Product_code,product.Product_Name,brand.Brand_name,unit.Unit_name,product.Cost FROM `product`,brand,unit WHERE product.Brand_ID=brand.Brand_id AND product.Unit_ID=unit.Unit_id");
    echo "<table border='1' style='margin-left: auto;margin-right: auto;'>";
    $counter = 0;
    while ($row = $data->fetch_assoc()) {
        if ($counter == 0) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<th>{$key}</th>";
            }
            echo "<th>SHOPS</th>";
            echo "</tr>";
            $counter++;
        }
        echo "</tr>";
        foreach ($row as $key => $value) {
            echo "<td>{$value}</td>";
        }
        echo "<td><a href='handle.php?delId={$row['Product_id']}'><'Shop Shock'></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}



function show_data($debug_mode)
{
    $mydb = new db("root", "", "person_data", $debug_mode);
    $data = $mydb->query("select * from person");
    $mydb->close();
    return $data;
}
function add_data($debug_mode, $name, $age)
{
    $mydb = new db("root", "", "person_data", $debug_mode);
    $mydb->query("INSERT INTO `person`(`name`, `age`) VALUES ('$name',$age)");
    $mydb->close();
}
function delete_id($debug_mode, $id)
{
    $mydb = new db("root", "", "person_data", $debug_mode);
    $mydb->query("DELETE FROM person WHERE id=$id");
    $mydb->close();
}
