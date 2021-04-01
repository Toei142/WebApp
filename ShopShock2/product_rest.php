<?php
session_start();
?>
<?php
include_once("class.db.php");
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    echo json_encode(product_list(), JSON_UNESCAPED_UNICODE);
} else if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    echo json_encode(open_bill());
}
function product_list()
{
    $db = new database();
    $db->connect();
    $sql = "SELECT Product_id,Product_code,Product_Name,
                       brand.Brand_name, unit.Unit_name,
                       product.Cost, product.Stock_Quantity
                FROM  product,brand,unit 
                WHERE product.Brand_ID = brand.Brand_id
                and   product.Unit_ID  = unit.Unit_id";
    $result = $db->query($sql, MYSQLI_NUM);
    $db->close();
    return $result;
}

function open_bill()
{
    //1. check  have some openbill?
    //   1.1 no: create new open_bill
    //   1.2 yes: check status openbill = 1?
    //      1.2.1 yes:
    //                check product Id exist yes: update qty in bill_detail
    //                check product Id exist no:  add product to bill_detail

    $p_id = $_POST['p_id'];
    $p_qty = $_POST['p_qty'];
    $p_price = $_POST['p_price'];

    $db = new database();
    $db->connect();
    $sql = "SELECT Bill_id, Bill_status FROM bill WHERE Cus_ID='{$_SESSION['cus_id']}' order by Bill_id desc limit 1";
    $bill_result = $db->query($sql, MYSQLI_NUM);
    $step = "";
    $bill_head = "";
    $bill_detail = "";
    if (sizeof($bill_result) == 0) {
        // insert new
        $step = "2:insert new";
        $sql = "INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) VALUES (1,'{$_SESSION['cus_id']}',0)";
        $result = $db->exec($sql);
        $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price)  VALUES (1, '{$p_id}', '{$p_qty}', '{$p_price}')";
        $result = $db->exec($sql);
    } else {
        $step = "3:add new item";
        // check [0][0] bill_id , [0][1] bill_status
        if ($bill_result[0][1] == 0) {
            $sql = "INSERT INTO bill_detail(Bill_id,Product_ID,Quantity,Unit_Price) VALUES({$bill_result[0][0]},{$p_id},{$p_qty},{$p_price})";
            $result = $db->exec($sql); //เพิ่มสินค้าถ้ามีแล้วจะได้ 0
            if ($result == 0) {
                $step = "4:update item";
                $sql = "SELECT Bill_id, Product_ID,Quantity FROM bill_detail WHERE Product_ID = '{$p_id}' AND `Bill_id`={$bill_result[0][0]} "; //แสดงจำนวนที่ซื้อเดิม
                $result = $db->query($sql, MYSQLI_NUM);
                $total = $p_qty + $result[0][2]; //เอาจำนวนสินค้าเดิม+จำนวนสินค้าเพิ่ม
                $sql = "UPDATE `bill_detail` SET `Bill_id`={$bill_result[0][0]},`Product_ID`={$p_id},`Quantity`='{$total}',`Unit_Price`={$p_price} WHERE Product_ID = {$p_id} AND `Bill_id`={$bill_result[0][0]}";
                $result = $db->exec($sql, MYSQLI_NUM);
                $step = "5:update complete";
            }
            $sql = "SELECT * FROM bill WHERE Bill_id={$bill_result[0][0]}";
            $bill_head = $db->query($sql, MYSQLI_NUM);
            $sql = "SELECT * FROM bill_detail where Bill_id={$bill_result[0][0]}";
            $bill_detail = $db->query($sql, MYSQLI_NUM);
        } else {
            // insert new
            $sql = "INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) SELECT MAX(Bill_id)+1,'{$_SESSION['cus_id']}',0 FROM bill";
            $result = $db->exec($sql);
            $sql = "INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) SELECT MAX(Bill_id), '{$p_id}', '{$p_qty}', '{$p_price}' FROM bill";
            $result = $db->exec($sql);
        }
    }
    return ["step" => $step, "bill" => $bill_head, "bill_detail" => $bill_detail];
}


?>