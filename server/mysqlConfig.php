<?php 

require_once ('dbConfig.php');

class MySQLConfig implements IDBConfig {
    private $host;
    private $dbname;
    private $user;
    private $password;

    public function __construct($host, $dbname, $user, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }

    public function getPDOConnectionParams() {
        return array(
            "dsn" => "mysql:host=$this->host;port=3306;dbname=$this->dbname;encoding=ut8mb4;",
            "user" => $this->user,
            "password" => $this->password
        );
    }
}