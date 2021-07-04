<?php
/**
 * Created by PhpStorm.
 * User: @htinlynn
 * Date: 04/07/2021
 * Time: 14:11
 */

class Database
{
    private $host = "mariadb";
    private $port = "3306";
    private $database_name = "web_test";
    private $username = "root";
    private $password = "root";

    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->database_name,
                $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Database could not be connected: ".$exception->getMessage();
        }
        return $this->conn;
    }
}
