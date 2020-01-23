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

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function snap() {
        // To catch fetch request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            $image = file_get_contents('php://input');
//            $str = json_decode($str);
//            $str = json_encode($str);
//            var_dump($str);
//            echo $image;
//            echo false;
//            $_POST['image'] = $image;
//            $this->add('asfdk;sadfl;saj');
//            var_dump($_FILES);
//                    var_dump($_SERVER);
//            $l = file_get_contents('php://input');
//            var_dump($l);
//            die('lOOOOL');
        } else {
            // Call view
            $this->view('posts/snap');
        }
    }

    public function add() {
//        var_dump($_POST);
//        var_dump($_FILES);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
        } else {
            die('l');
        }
    }
}
