<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/settings-screen.php';
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

$params['form'] = $form;
$params['form_msg'] = '';
$params['form_result'] = '';

$latte->render('templates/settings-screen.latte', $params);

?>