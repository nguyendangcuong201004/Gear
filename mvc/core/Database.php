<?php
class Database {
    public $con;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "gear";

    public function __construct() {
        $this->con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // Set charset to utf8mb4 which supports all unicode characters including Vietnamese
        mysqli_set_charset($this->con, "utf8mb4");
    }
}
