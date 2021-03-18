<?php
include_once "01 db.php";
include_once "util.php";
$debug_mode = true;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    debug_text("GET METHOD Process....", $debug_mode);
    echo json_encode(show_data($debug_mode));
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    debug_text("POST METHOD May be implement soon.....", $debug_mode);
    $message = array("status" => print_r($_POST));
    add_data($debug_mode, $_POST['u_name'], $_POST['u_age']);
    echo json_encode($message);
} else {
    debug_text("Error this site Unsupport This request", $debug_mode);
    http_response_code(405);
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
