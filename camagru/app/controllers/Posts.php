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

    private function uploadImage($image): string
    {
        // Get photo extension
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        // Generate file name
        $filename = uniqid() . '.' . $extension;

        $dest = APPROOT . '/data';

        if (!file_exists($dest)) {
            echo $dest;
            // TODO give rights to mkdir, currently not working
            mkdir($dest, 755, true);
        }

        echo getcwd();

        // Upload on server
        move_uploaded_file($image['tmp_name'], '../app/data/' . $filename);

        return $filename;
    }

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

            // Sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'photo' => $this->uploadImage($_FILES['photo']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id']
            ];


            exit;
        }
        $this->view('posts/add');
    }
}

// TODO add session control
