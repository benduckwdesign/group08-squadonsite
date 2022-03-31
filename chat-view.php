<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/chat-view.php';
require_once 'config.php';
require_once 'db/db.php';

$params = [
	'siteroot' => $siteroot
];

$test_message = new stdClass;
$test_message->username = "Kirby";
$test_message->message = "poyo poyopoyo poyo~";

$test_chat = $chat_db->get('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
$test_chat->messages = [
    $test_message
];

$test_chat->save();

$form_msg = "";
$form_result = "";
$chat_messages = null;
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
$params['chat_messages'] = $chat_messages;

$latte->render('templates/chat-view.latte', $params);

?>