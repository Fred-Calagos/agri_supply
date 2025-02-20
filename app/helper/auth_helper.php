<?php

session_start(); // Ensure session is started before using it

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Admin';
}

function isUser() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'User';
}

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }
}

function checkAdmin() {
    if (!isAdmin()) {
        header("Location: /customer/dashboard");
        exit;
    }
}
function checkLogin() {
    if (isset($_SESSION['user'])) {
        header("Location: /dashboard");
        exit;
    }
}