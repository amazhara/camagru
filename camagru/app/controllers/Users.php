<?php

/*
 * User option controller
 * Loads Users model and view
 */
// TODO make js script to remove error on click
class Users extends Controller
{
    // To hold loaded model
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function register($data = []) {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('/pages/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Filter post request
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Convert data in array
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'token' => md5(uniqid(rand(), true)),
                'recover_token' => md5(uniqid(rand(), true)),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Check email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please fill email field';
            } elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'This email is already used, please fill another one';
            }

            // Check name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please fill name field';
            } elseif(strlen($data['name']) < 4) {
                $data['name_err'] = 'Name must be at least 4 characters';
            }

            // Check password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please fill password field';
            } elseif (strlen($data['password']) < 6) {
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
                if ($this->userModel->register($data)) {
                    $this->mail($data['email'], $data['token']);
                    flash('register_success', 'You need to confirm your email to login');
                    redirect('/users/login');
                } else {
                    // TODO same problem with 404 error (search for all dies and fix)
                    die('Something went wrong');
                }
            }
        } else {
            $data = [
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

    public function login($data = []) {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('/pages/index');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Convert data in array
            $data = [
              'email' => trim($_POST['email']),
              'password' => trim($_POST['password']),
              'email_err' => '',
              'password_err' => ''
            ];

            // Check for email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif ($this->userModel->findUserByEmail($data['email']) == false) {
                $data['email_err'] = 'Email not found';
            }

            // Check for password
            if (empty($data['password'])) {
                $data['password'] = 'Please enter your password';
            }

            // If no errors found
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Search for user
                $user = $this->userModel->login($data['email'], $data['password']);

                // Check if password is correct and create session
                if ($user) {
                    // Check verification
                    if ($this->userModel->getVerifiedById($user->id)) {
                        $this->createUserSession($user);
                    } else {
                        flash('register_success', 'Verify account by link sent to you\'re email first', 'alert alert-danger');
                    }
                } else {
                    $data['email_err'] = 'No such email found';
                }
            }

        } else {
            $data = [
                'email' => '',
                'password' => '',
                'name_error' => '',
                'password_err' => ''
            ];
        }
        $this->view('users/login', $data);
    }

    public function settings() {
        // Check if user is logged in
        if (!isLoggedIn()) {
            flash('login_to_post', 'Login to enter settings');
            redirect('/users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Convert data in array
            $data = [
                'email' => trim($_POST['email']),
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),
                'id' => $_SESSION['user_id'],
                'email_err' => '',
                'name_err' => '',
                'password_err' => ''
            ];

            if (!empty($data['email'])) {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'This email is already used, please fill another one';
                 } else {
                    $this->userModel->updateUserEmail($data);
                }
            }

            if (!empty($data['password'])) {
                if (strlen($data['password'] < 6)) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                } else {
                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $this->userModel->updateUserPassword($data);
                }
            }

            if (!empty($data['name'])) {
                if(strlen($data['name']) < 4) {
                    $data['name_err'] = 'Name must be at least 4 characters';
                } else {
                    $this->userModel->updateUserName($data);
                }
            }

        } else {
            $data = [
                'email' => '',
                'name' => '',
                'password' => '',
                'email_err' => '',
                'name_err' => '',
                'password_err' => ''
            ];
        }

        $this->view('users/settings', $data);
    }

    public function recover() {
        if (isLoggedIn()) {
            redirect('/posts');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Convert data in array
            $data = [
                'email' => trim($_POST['email']),
                'email_err' => '',
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'No such email found';
            }

            if (empty($data['email_err'])) {
                $user = $this->userModel->getUserByEmail($data['email']);
                $this->mailRecover($user->email, $user->recover_token);
            }

        } else {
            $data = [
                'email' => '',
                'email_err' => ''
            ];
        }

        $this->view('users/recover', $data);
    }

    public function createUserSession($user) {
        // Save user info in session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('/posts');
    }

    public function logout() {
        // Delete user info from session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        // Destroy session
        session_destroy();
        redirect('/users/login');
    }

    private function mail($email, $token) {
        mail($email, 'Email confirmation',
            'To confirm your email use this link - ' . URLROOT . '/users/verify/' . $token);
    }

    private function mailRecover($email, $token) {
        mail($email, 'Email recover',
            'Recover email link - ' . URLROOT . '/users/change/' . $token);
    }

    public function verify($token) {
        $data = [
            'token' => $token
        ];
        $user = $this->userModel->getUserByToken($data['token']);
        if ($user) {
            $this->userModel->setVerifiedUserById($user->id);
            flash('register_success', 'You\'re verified and now can log in');
        } else {
            flash('register_success', 'Something went wrong with verification - use valid link');
        }
        redirect('/users/login');
    }
}
