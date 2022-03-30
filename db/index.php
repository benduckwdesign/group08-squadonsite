<?php

$subfolder = "/new";

require_once __DIR__.'/vendor/autoload.php';

$latte = new Latte\Engine;

$latte->setTempDirectory(__DIR__.$subfolder.'/cache/');

include __DIR__.'/forms/signup.php';

$params = [
	'hello' => 'This is a test to make sure dependencies are working.',
	'form' => $form,
];

$latte->render(__DIR__.'/templates/test.latte', $params);

if ($form->isSuccess()) {
	echo 'The form has been filled in and submitted correctly';
	$data = $form->getValues();
	// $data->name contains name
	// $data->password contains password
	var_dump($data);
}

?>
