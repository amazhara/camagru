<?php

/*
 * Mode class for User
 * Fill information in users table
 * Return information from users table
 */


class User {

    // Database core class instance
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Register user in table
    public function register($data) : bool {
        // Sql query
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function login($email, $password) {
        // Sql query
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        // Get table row
        $row = $this->db->single();

        // Check if db return raw
        $hashedPassword = $row ? $row->password : false;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    // Check if email exists
    public function findUserByEmail($email) : bool {

        $this->db->query('SELECT * FROM users WHERE email = :email');

        // Bind value
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Check if email exists
    public function findUserById($id) : bool {

        $this->db->query('SELECT * FROM users WHERE id = :id');

        // Bind value
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');

        // Bind value
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function updateUserEmail($data) : bool {
        $this->db->query('UPDATE users SET email = :email WHERE id = :id ');

        // Bind value
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserName($data) : bool {
        $this->db->query('UPDATE users SET name = :name WHERE id = :id ');

        // Bind value
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':id', $data['id']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserPassword($data) : bool {
        $this->db->query('UPDATE users SET password = :password WHERE id = :id ');

        // Bind value
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':id', $data['id']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
