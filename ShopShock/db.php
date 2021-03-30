<?php
class db
{
    private $db;
    function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "shopshock");
        $this->db->set_charset("utf8");
        if ($this->db->connect_errno) echo "Fail to connect to Mysql:" . $this->db->connect_error;
    }
    function query($sql)
    {
        $result = $this->db->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }
    function queryNUM($sql)
    {
        $result = $this->db->query($sql);
        $data = $result->fetch_all(MYSQLI_NUM);
        return $data;
    }
    function CUD($sql)
    {
        return $this->db->query($sql);
    }
    function close()
    {
        $this->db->close();
    }
}
