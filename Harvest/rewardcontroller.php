<?php
class rewardcontroller {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "harvest_db";
    
    function __construct() {
        $conn = $this->connectDB();
    }
    
    function connectDB() {
        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $conn;
    }
    
    function selectDB($conn) {
        mysqli_select_db($conn, $this->database);
    }
    
    function runQuery($query) {
        $conn = $this->connectDB();
        $result = mysqli_query($conn, $query) or die("Query Error: " . mysqli_error($conn));
        $resultset = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        return $resultset;
    }
    
    function numRows($query) {
        $result  = mysqli_query($query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
}
?>