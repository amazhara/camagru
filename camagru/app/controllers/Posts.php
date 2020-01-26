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
        $this->postModel = $this->model('Post');
    }

    public function index() {
        // User must log in to see posts
        if (!isLoggedIn()) {
            flash('login_to_see_posts', 'Please, login to see posts list');
            redirect('/users/login');
        }

        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts
        ];

//        header('Content-Type:text/plain');
//        foreach ($data['posts'] as $post) {
//            echo ;
//        }
//        $this->view('posts/index', $data);
    }

    public function add()
    {
        // Check if user logged in
        if (isLoggedIn() == false) {
            flash('login_to_post', 'Please, login to create post');
            redirect('/users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                // Get photo id
                'photo' => $this->uploadImage($_FILES['photo']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id']
            ];

            if (!empty($data['photo']) && !empty($data['body']) && !empty('user_id')) {
                // Call model
                if ($this->postModel->add($data)) {
                    // Success answer to js
                    echo 'success';
                } else {
                    // Failed answer to js
                    echo 'failed';
                }
            }

        } else {
            $this->view('posts/add');
        }
    }

    private function uploadImage($image): string
    {
        // Get photo extension
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        // Generate file name
        $filename = uniqid() . '.' . $extension;

        $dest = APPROOT . '/data';

        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        // Upload on server
        move_uploaded_file($image['tmp_name'], $dest . '/' . $filename);

        return $filename;
    }
}

// TODO add session control
