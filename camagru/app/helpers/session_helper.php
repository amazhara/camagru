<?php

// Start session every time program instantiates
session_start();

// Default check if user is logged in
function isLoggedIn(): bool {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

/*
 * Show flesh message to users
 * Message is held in $_SESSION array
 * First call to save massage -> flash('register_success', 'You can now log in')
 * Then call with only name to print -> flash('register_success')
 */
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {

            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}
