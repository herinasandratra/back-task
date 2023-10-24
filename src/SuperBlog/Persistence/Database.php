<?php 
namespace SuperBlog\Persistence;
class Database {
    private static $instance;
    private $connection;

    

    private function __construct() {
        $host = DbConf::HOST;
        $db = DbConf::DB;
        $user = DbConf::USER;
        $pass = DbConf::PASSWORD;
        $this->connection = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

