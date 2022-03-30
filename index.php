<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/signup.php';
require_once 'config.php';
require_once 'db/db.php';

$form_msg = "";
$form_result = "";
if ($form->isSuccess()) {
	$data = $form->getValues();
	$user_exists = $user_db->has($data->username);
	if ($user_exists == False) {
		$user = $user_db->get($data->username);
		$user->password = $data->password;
		$user->save();
		$form_msg = 'You have successfully been registered.';
		// $form_result = var_export($data, true); //debug only
	} else {
		$form['username']->addError('That username is already taken.');
	}
	
}

$params = [
	'siteroot' => $siteroot,
	'form' => $form,
	'form_result' => $form_result,
	'form_msg' => $form_msg,
];

$latte->render('templates/signup.latte', $params);

?>
