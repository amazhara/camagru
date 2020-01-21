<?php

/*
 * Posts controller
 * Snap photos
 * Add posts
 * Comment posts
 * Like posts
 */

class Posts extends Controller {

    private $userModel;

    function __construct() {
        $this->userModel = $this->model('User');
    }

    function add($data = []) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            echo '<br>';
            var_dump($_FILES);
        }
        $this->view('posts/add');
    }
}
