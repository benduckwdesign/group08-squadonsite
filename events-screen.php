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

$user_data = $user_db->get($_SESSION['username']);
if (is_null($user_data->events)) {
    global $user_data;
    $user_data->events = [];
    $user_data->save();
}

$params = [
	'siteroot' => $ROOTURL,
    'events' => $user_data->events,
];

$latte->render('templates/events-screen.latte', $params);

?>