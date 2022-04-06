<?php

require_once 'config.php';
require_once 'db/db.php';

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_unset();

session_destroy();

header("Location: $ROOTURL/login-screen.php");
die();

?>