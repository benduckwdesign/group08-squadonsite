<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

$latte->setTempDirectory('cache/');

include 'forms/signup.php';

$params = [
	'hello' => __DIR__,
	'form' => $form,
];

$latte->render('templates/test.txt', $params);

if ($form->isSuccess()) {
	echo 'The form has been filled in and submitted correctly';
	$data = $form->getValues();
	// $data->name contains name
	// $data->password contains password
	var_dump($data);
}

?>
