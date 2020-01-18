<?php

/*
 *
 */
class Posts extends Controller {

    private $userModel;

    function __construct() {
        $this->userModel = $this->model('User');
    }

    function add($data = []) {
        $data = [
            'title' => '',
            'body' => ''
        ];
        $this->view('posts/add');
    }
}