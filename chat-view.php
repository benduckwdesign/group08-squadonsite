<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/chat-view.php';
require_once 'config.php';
require_once 'db/db.php';

$params = [
	'siteroot' => $ROOTURL
];

$test_message = new stdClass;
$test_message->username = "Kirby";
$test_message->message = "poyo poyopoyo poyo~";

$test_chat = $chat_db->get('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
$test_chat->messages = array(
    $test_message,
    $test_message,
    $test_message
    );
$test_chat->save();

$form_msg = "";
$form_result = "";
$chat_messages = null;
if ($form->isSuccess()) {
    global $params;
    global $form;
    global $chat_db;
	$data = $form->getValues();
	$chat_exists = $chat_db->has($data->id);
	if ($chat_exists == True) {
        global $chat_db;
        global $params;
        global $data;
        global $form;
        // Load chat if it exists
		$form = null;
        $params['chat_messages'] = "";
        foreach ($chat_db->get($data->id)->field('messages') as $message) {
            $params['chat_messages'] = $params['chat_messages'] . "<li>";
            $params['chat_messages'] = $params['chat_messages'] . "<h6>" . $message->username . "</h6>";
            $params['chat_messages'] = $params['chat_messages'] . "<p>" . $message->message . "</p>";
            $params['chat_messages'] = $params['chat_messages'] . "</li>";
        }
	} else {
        global $form;
        // Create new chat if it doesn't?
		$form['id']->addError('That conversation does not exist.');
	}
	
}
$params['form_msg'] = $form_msg;
$params['form'] = $form;
$params['chat_messages'] = $chat_messages;

$latte->render('templates/chat-view.latte', $params);

?>