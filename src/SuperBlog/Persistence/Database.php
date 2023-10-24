<?php 
namespace SuperBlog\Persistence;
/**
 * Summary of Database
 */
class Database {
    /**
     * Summary of instance
     * @var 
     */
    private static $instance;
    /**
     * Summary of connection
     * @var 
     */
    private $connection;

    

    /**
     * Summary of __construct
     */
    private function __construct() {
        $host = DbConf::HOST;
        $db = DbConf::DB;
        $user = DbConf::USER;
        $pass = DbConf::PASSWORD;
        $this->connection = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Summary of getInstance
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Summary of getConnection
     * @return \PDO
     */
    public function getConnection() {
        return $this->connection;
    }
}

