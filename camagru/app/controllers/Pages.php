<?php

/*
 * Default Controller
 * Instantiate default page
 */

class Pages {

    // Default method
    public function index() {
        $data = [
            'title' => 'Camagru',
            'description' => 'Social network to share photos'
        ];

        echo $data['title'] . '<br>';
        echo $data['description'] . '<br>';
    }

    // About us page
    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share photos with other users'
        ];
        echo $data['title'] . '<br>';
        echo $data['description'] . '<br>';
    }
}
