<?php

require_once 'vendor/autoload.php';

require_once 'config.php';
require_once 'db/db.php';

if (!isset($_SESSION['username'])) { // Redirect if not logged in
    global $ROOTURL;
    header("Location: $ROOTURL/login-screen.php");
    die();
}

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

$params = [
	'siteroot' => $ROOTURL
];

$latte->render('templates/support-screen.latte', $params);

?>