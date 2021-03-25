<?php
class db
{
    private $db;
    function __construct($username, $password, $dbname)
    {
        $this->db = new mysqli("localhost", $username, $password, $dbname);
        $this->db->set_charset("utf8");
        if ($this->db->connect_errno) {
            echo "Fail to connect to Mysql:" . $this->db->connect_error;
            exit();
        } //else echo  "Connect Success";
    }
    function query($sql)
    {
        $result = $this->db->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }
    function CUD($sql)
    {
        $result = $this->db->query($sql);
        return $result;
    }
    function close()
    {
        $this->db->close();
    }
}
