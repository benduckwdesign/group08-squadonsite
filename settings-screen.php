<?php

require_once 'vendor/autoload.php';

// $latte->setTempDirectory('cache/');

require_once 'config.php';
require_once 'db/db.php';

if (!isset($_SESSION['username'])) { // Redirect if not logged in
    global $ROOTURL;
    header("Location: $ROOTURL/login-screen.php");
    die();
}

$latte = new Latte\Engine;
require_once 'forms/settings-screen.php';

$params = [
	'siteroot' => $ROOTURL
];

$params['form'] = $form;
$params['form_msg'] = '';
$params['form_result'] = '';

$latte->render('templates/settings-screen.latte', $params);

?>