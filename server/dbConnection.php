<?php

class DatabaseConnection {
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function getPDOConntection() {
        $connection = $this->config->getPDOConnectionParams();
        if (array_key_exists('user', $connection)) {
            try {
                return new PDO($connection['dsn'], $connection['user'], $connection['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch(PDOException $pe){
                echo $pe->getMessage();
            }
        }
        return new PDO($connection['dsn']);
    }
}