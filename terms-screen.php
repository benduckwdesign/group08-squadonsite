<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'config.php';
require_once 'db/db.php';

$params = [
	'siteroot' => $ROOTURL
];

$latte->render('templates/terms-screen.latte', $params);

?>