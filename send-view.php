<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/send-view.php';
require_once 'config.php';
require_once 'db/db.php';

$params = [
	'siteroot' => $ROOTURL
];

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
        
	} else {
        global $form;
        // Create new chat if it doesn't?
		$form['message']->addError('That conversation does not exist.');
	}
	
}
$params['form_msg'] = $form_msg;
if (isset($_SESSION['chat_id']) == False) {
    $form['message']->addError('That conversation does not exist.');
} else {
    $params['form'] = $form;
}

$latte->render('templates/chat-view.latte', $params);

?>