<?php


/*
 * Post model class
 * Save posts
 * Search for posts
 * Delete posts
 * Return posts
 */

class Post
{
    private $db;

    function __construct() {
        $this->db = new Database;
    }

    function add($data) {
        // Set prepared query
        $this->db->query('INSERT INTO posts (photo, user_id, body) VALUES (:photo, :user_id, :body)');
        // Bind values
        $this->db->bind(':photo', $data['photo']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

//    function findPostById($id) {
//
//    }
}
