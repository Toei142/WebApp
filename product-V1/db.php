<?php
class db
{
    private $db;
    function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "itishop");
        $this->db->set_charset("utf8");
        if ($this->db->connect_errno) echo "Fail to connect to Mysql:" . $this->db->connect_error;
    }
    function query($sql,$option)
    {
        $result = $this->db->query($sql);
        $data = $result->fetch_all($option);
        return $data;
    }
    function exec($sql)
    {
        return $this->db->query($sql);
    }
    function close()
    {
        $this->db->close();
    }
}
