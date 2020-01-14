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

        // Connect to db and create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOExceptionπ $e) {
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
        return $this->stmt->rowCount();
    }
}
