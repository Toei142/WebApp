
<?php
define("hostname", "localhost");
define("username", 'user');
define("password", "ec1L9W4hnfSNcQia");
define("dbname", "bookstore");
class Database
{
    public $conn = null;
    public function __construct()
    {
        $this->conn = new mysqli(hostname, username, password, dbname);
        $this->conn->query("SET NAMES UTF8");
        if ($this->conn->connect_error) echo "not connect";
        // else echo "Connect success55";
    }

    public function showBook()
    {

        $sql = "SELECT * FROM `book` WHERE 1";
        $result = $this->conn->query($sql);
        echo "<table border='1'>";
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
            if ($counter == 0) {
                echo "<tr style='background-color:black'><th colspan='11'><h1 style='color:green'>Manage Book</h1></th></tr>";
                echo "<tr style=''><th colspan='11' align='left'><a href='insertBook.php'>+Book</a></th></tr>";
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<th>{$key}</th>";
                }
                echo "<th>OPERATION</th>";
                echo "</tr>";
                $counter++;
            }
            echo "</tr>";
            foreach ($row as $key => $value) {
                if ($key != 'Picture') {
                    echo "<td>{$value}</td>";
                } else   echo "<td><img src = '{$value}'></td>";
            }

            echo "<td><a href='handle.php?delId={$row['BookID']}'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    public function insertData($data)
    {
        $sql = "INSERT INTO `book`(`BookID`, `BookName`, `TypeID`, `StatusID`, `Publish`, `UnitPrice`, `UnitRent`, `DayAmount`, `Picture`) 
        VALUES ('{$data['id']}','{$data['name']}','{$data['type']}','{$data['status']}','{$data['pub']}',{$data['unitp']},{$data['unitr']},{$data['day']},'{$data['pic']}')";
        $result = $this->conn->query($sql);
        echo $sql;
        echo $result;
    }
    public function disconnect()
    {
        $this->conn->close();
    }
    public function sltType()
    {
        $sql = "SELECT * FROM typebook";
        $result = $this->conn->query($sql);
        echo "<select name='typeID'>";
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
            }
            echo "<option value='{$row['TypeID']}'>{$row['TypeName']}</option>";
        }
        echo "</select>";
    }
    public function sltStatus()
    {
        $sql = "SELECT * FROM statusbook";
        $result = $this->conn->query($sql);
        echo "<select name='stautsID'>";
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
            }
            echo "<option value='{$row['StatusID']}'>{$row['StatusName']}</option>";
        }
        echo "</select>";
    }
}
?>
