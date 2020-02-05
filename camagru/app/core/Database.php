<?php

/*
 * Database class
 * Create prepared statements
 * Connect to database
 * Bind values
 * Return rows and results
 */

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        // Set options
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        // Create db and all tables
        $this->prepare($options);

        // Connect to db and create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with sql query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Execute prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Bind values
    public function bind($param, $value, $type = null) {
        // Check type
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Get result set as array of objects and methods eq rows
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Ger row count
    public function rowCount() {
        $this->execute();
        return $this->stmt->rowCount();
    }

    private function prepare($options) {

        try {
            $dbh_tmp = new PDO('mysql:host=' . $this->host , $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
            die('Need to change host in config file or create database by hands, some critical error happened');
        }

        // Create Db
        $dbh_tmp->exec('CREATE DATABASE IF NOT EXISTS camagru');

        // Create users table
        $dbh_tmp->exec("
            CREATE TABLE IF NOT EXISTS `camagru`.`users` ( `id` INT NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL ,
            `password` VARCHAR(60) NOT NULL ,
            `verified` INT NOT NULL DEFAULT '0',
            `token` VARCHAR(255) NULL DEFAULT NULL,
            `recover_token` VARCHAR(255) NULL DEFAULT NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ");

        // Create posts table
        $dbh_tmp->exec("
            CREATE TABLE IF NOT EXISTS `camagru`.`posts` ( `id` INT NOT NULL AUTO_INCREMENT ,
            `user_id` INT NOT NULL , `photo` VARCHAR(255) NOT NULL ,
            `body` VARCHAR(255) NOT NULL , `likes_count` INT NULL DEFAULT NULL ,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ");

        // Create likes table
        $dbh_tmp->exec("
            CREATE TABLE IF NOT EXISTS `camagru`.`likes` ( `id` INT NOT NULL AUTO_INCREMENT ,
            `user_id` INT NOT NULL , `post_id` INT NOT NULL ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ");

        // Create comments table
        $dbh_tmp->exec("
            CREATE TABLE IF NOT EXISTS `camagru`.`comments` ( `id` INT NOT NULL AUTO_INCREMENT ,
            `user_id` INT NOT NULL , `post_id` INT NOT NULL ,
            `body` VARCHAR(255) NOT NULL , `user_name` VARCHAR(255) NOT NULL ,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ");
    }
}
