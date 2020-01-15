<?php

// Start session every time program instantiates
session_status();

// Default check if user is logged in
function isLoggedIn() : bool {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}
