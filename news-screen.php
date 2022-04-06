<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'config.php';
require_once 'db/db.php';

$params = [
	'siteroot' => $ROOTURL
];

if (isset($_SESSION['username'])) {
    // pass
} else {
    header("Location: $ROOTURL/login-screen.php");
    die();
}

$latte->render('templates/news-screen.latte', $params);

?>