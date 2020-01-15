<?php

/*
 * User option controller
 * Loads Users model and view
 */

class Users extends Controller
{
    private $currentModel;

    public function __construct() {
        $this->currentModel = $this->model('User');
    }
}
