<?php

/*
 * Base Controller class
 * Instantiate models and views
 */

class Controller
{
    // Load model
    public function model($model) {
        // require model
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model;
    }

    // Load view
    public function view($view, $data = []) {
        // Check if view file exists and require
        if (file_exists('../app/view/' . $view . '.php')) {
            require_once '../app/view/' . $view . '.php';
        } else {
//             TODO make better error massage for ex 404 error
//            die('View does not exists');
        }
        var_dump($data);
    }
}
