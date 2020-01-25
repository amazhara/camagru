<?php

/*
 * Posts controller
 * Snap photos
 * Add posts
 * Comment posts
 * Like posts
 */

class Posts extends Controller
{

    private $userModel;
    private $postModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function add()
    {
        // Check if user logged in
        if (isLoggedIn() == false) {
            flash('login_to_post', 'Please, login to create post');
            redirect('/users/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            exit;
        }
        $this->view('posts/add');
    }
}

// TODO add session control
