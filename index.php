<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

include 'forms/signup.php';
include 'config.php';

$form_msg = "";
$form_result = "";
if ($form->isSuccess()) {
	$form_msg = 'The form has been filled in and submitted correctly.';
	$data = $form->getValues();
	// $data->name contains name
	// $data->password contains password
	$form_result = var_export($data, true);
}

$params = [
	'siteroot' => $siteroot,
	'form' => $form,
	'form_result' => $form_result,
	'form_msg' => $form_msg,
];

$latte->render('templates/signup.latte', $params);

?>
