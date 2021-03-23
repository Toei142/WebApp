<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    session_start();
    if ($_SESSION['member_id'] == null) {
        header('Location:Login.php');
    }
    ?>
</head>

<body>

    <div>
        <div style="text-align: center;">
            <a href="">สั่งซื้อสินค้า</a> <a href="">ชำระเงิน</a> <a href="Logout.php">ออกจากระบบ</a>
        </div>
        <div style="text-align: right;">
            <h3>
                <?php
                echo  "ยินดีต้อนรับ<br>คุณ" . $_SESSION['name'];
                ?>
            </h3>
        </div>

        <h1 style="text-align: center;">SHOPSHOCK</h1>
        <?php
        include_once "rest.php";
        show_productList($debug_mode);
        ?>
    </div>
</body>

</html>