<?php

/*
 * Default Controller
 * Cover default page
 * Dont load any models
 */

class Pages extends Controller {

    // Default method
    public function index() {
        $data = [
            'title' => 'Camagru',
            'description' => 'Social network to share photos'
        ];
        $this->view('pages/index', $data);
    }

    // About us page
    public function about() {
        $data = [
            'title' => 'About Camagru',
            'description' => 'App to share photos with other users',
            'author' => 'Written By Arthur Mazhara'
        ];
        $this->view('pages/about', $data);
    }

    // 404 error
    public function none() {
        $this->view('pages/none');
    }
}
