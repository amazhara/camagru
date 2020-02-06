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
        // Get all posts info from model
        $posts = $this->postModel->getPosts();

        // Check whether user like some post
        if (isLoggedIn()) {
            foreach ($posts as $post) {
                $likes = $this->postModel->getLikesByPostId($post->postId);

                foreach ($likes as $like) {
                    if ($like->user_id === $_SESSION['user_id']) {
                        // Add field with likes
                        $post->isLiked = true;
                    }
                }
            }
        }

        $data = [
            'posts' => $posts
        ];

        // TODO make view responsive
        $this->view('posts/index', $data);
    }

    public function show($id) {
        // Check for login
        if (!isLoggedIn()) {
            flash('login_to_post', 'Please, login to see comments');
            redirect('/users/login');
        }

        $post = $this->postModel->getPostById($id);
        $comments = $this->postModel->getCommentsByPostId($id);
        $user = $this->userModel->getUserById(($_SESSION['user_id']));

        if (!$post) {
            redirect('/posts');
        }

        $data = [
            'post' => $post,
            'user' => $user,
            'comments' => $comments
        ];

        $this->view('posts/show', $data);
    }

    public function comment() {
        // Check if user logged in
        if (isLoggedIn() == false) {
            flash('login_to_post', 'Please, login to comment');
            redirect('/users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
              'body' => trim($_POST['body']),
              'post_id' => trim($_POST['post_id']),
              'user_id' => $_SESSION['user_id'],
              'user_name' => $this->userModel->getUserById($_SESSION['user_id'])->name
            ];

            if (!empty($data['body']) && !empty($data['post_id']) && !empty($data['user_id']) && !empty($data['user_name'])) {
                // Save comment
                $this->postModel->comment($data);
                $post = $this->postModel->getPostById($data['post_id']);
                $receiver = $this->userModel->getUserById($post->user_id);
                $this->mail($receiver->email, $receiver->name, $post->id);
            }
            redirect('/posts/show/' . $_POST['post_id']);
        }

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

    public function like()
    {
        // Check if user logged in
        if (isLoggedIn() == false) {
            flash('login_to_post', 'Please, login to like post');
            redirect('/users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            // Sanitize array
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'post_id' => trim($_GET['id'])
            ];

            // Check if get request is correct
            if (!empty($data['post_id']) && !empty($data['user_id'])) {

                $post = $this->postModel->getPostById($data['post_id']);
                $user = $this->userModel->getUserById($data['user_id']);

                if ($post && $user) {
                    $likes = $this->postModel->getLikesByUserId($data['user_id']);

                    foreach ($likes as $like) {
                        if ($like->post_id === $data['post_id']) {
                            // Delete like if user pressed button twice
                            $this->postModel->deleteLikeById($like->id);
                            $this->postModel->postUpdateLikesCount($data['post_id']);
                            redirect('/posts');
                            exit;
                        }
                    }

                    $this->postModel->like($data);
                    $this->postModel->postUpdateLikesCount($data['post_id']);
                }
            }
            redirect('/posts');
        }
    }

    public function delete($id)
    {
        // Check if user logged in
        if (isLoggedIn() == false) {
            redirect('/posts');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            //get existing post from model
            $post = $this->postModel->getPostById($id);

            // Check if post exists
            if (!$post) {
                redirect('/posts');
                return;
            }

            //check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('/posts');
                return;
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Removed');
                redirect('/posts');
            }
        }
    }

    private function uploadImage($image): string
    {
        // Get photo extension
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        // Generate file name
        $filename = uniqid() . '.' . $extension;

        $dest = dirname(APPROOT) . '/public' . '/data';

        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }

        // Upload on server
        move_uploaded_file($image['tmp_name'], $dest . '/' . $filename);

        return $filename;
    }

    private function mail($email, $name, $id) {
        mail($email,
            'New comment', 'Your post ' . URLROOT . '/posts/show/' . $id . ' was commented by ' . $name);
    }
}
