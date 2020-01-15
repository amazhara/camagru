<?php

/*
 * User option controller
 * Loads Users model and view
 */

class Users extends Controller
{
    // To hold loaded model
    private $currentModel;

    public function __construct() {
        $this->currentModel = $this->model('User');
    }

    public function register($data = []) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Filter post request
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Convert data in array
            $data =[
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Check email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please fill email field';
            } elseif ($this->currentModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'This email is already used, please fill another one';
            }

            // Check name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please fill name field';
            }

            // Check password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please fill password field';
            } elseif (strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // Check Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please fill confirm_password field';
            } elseif($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            // Check for no errors found
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->currentModel->register($data)) {
                    flash('register_success', 'You are registered and can log in');
                    die('SUCCESS');
//                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            }
        } else {
            $data =[
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
        }
        $this->view('users/register', $data);
    }
}
