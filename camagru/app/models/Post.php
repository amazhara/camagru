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

    public function __construct() {
        $this->db = new Database;
    }

    public function getPosts() {
        $this->db->query(
            "SELECT *,
                 posts.id as postId,
                 users.id as userId,
                 posts.created_at as postCreated,
                 users.created_at as userCreated
                 FROM posts
                 INNER JOIN users
                 ON posts.user_id = users.id
                 ORDER BY posts.created_at DESC 
            ");
        return $this->db->resultSet();
    }

    public function add($data) : bool {
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

    public function like($data) : bool {
        // Prepare query
        $this->db->query('INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)');
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':post_id', $data['post_id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findLikesByUserId($id) {
        $this->db->query('SELECT * FROM likes where user_id = :id');
        $this->db->bind(':id', $id);

        $likes = $this->db->resultSet();
        return $likes;
    }

    public function deleteLikeById($id) {
        $this->db->query('DELETE * FROM likes where id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function findPostById($id) {
        $this->db->query('SELECT * FROM posts where id = :id');
        $this->db->bind(':id', $id);

        $post = $this->db->single();
        return $post;
    }

    public function deletePostById($id) : bool {
        $this->db->query('DELETE * FROM posts where id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
