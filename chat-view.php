<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/chat-view.php';
require_once 'config.php';
require_once 'db/db.php';

$params = [
	'siteroot' => $siteroot,
];

$form_msg = "";
$form_result = "";
if ($form->isSuccess()) {
	$data = $form->getValues();
	$chat_exists = $chat_db->has($data->id);
	if ($chat_exists == True) {
        // Load chat if it exists
		$form = null;
        $chat_messages = $chat_db->get($data->id);
        $params['chat_messages'] = $chat_messages->messages;
	} else {
        // Create new chat if it doesn't?
		$form['id']->addError('That conversation does not exist.');
	}
	
}
$params['form_msg'] = $form_msg;
$params['form'] = $form;

$latte->render('templates/chat-view.latte', $params);

?>