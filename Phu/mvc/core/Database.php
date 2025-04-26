<?php
class Database {
    public $con;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "gear";

    public function __construct() {
        $this->con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        mysqli_set_charset($this->con, 'utf8');
    }
}
