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
    if (isset($_SESSION['chat_id']) == True) {
    
    } else {
        $_SESSION['chat_id'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
    }
} else {
    header("Location: $ROOTURL/login-screen.php");
    die();
}

$params['chat_id'] = $_SESSION['chat_id'];

$latte->render('templates/chat-screen.latte', $params);

?>