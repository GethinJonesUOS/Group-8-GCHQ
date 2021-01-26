<?php
    session_start();

/**
 * Check if session is set
 */
    function isLoggedIn() {
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }