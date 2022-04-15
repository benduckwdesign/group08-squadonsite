<?php

// header("Refresh:2");

require_once 'vendor/autoload.php';

require_once 'config.php';
require_once 'db/db.php';

$latte = new Latte\Engine;
// $latte->setTempDirectory('cache/');
// require_once 'forms/chat-view.php';

if (!isset($_SESSION['username'])) { // Die if not logged in
    global $ROOTURL;
    die();
}

$params = [
	'siteroot' => $ROOTURL
];


// Create default test chat
if ($chat_db->has('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa') == False) {
    $test_message = new stdClass;
    $test_message->username = "Squad On Site";
    $test_message->message = "A new conversation has been created. Enjoy!";

    $test_chat = $chat_db->get('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
    $test_chat->messages = array(
        $test_message
    );
    $test_chat->save();
}
//


// $form_msg = "";
// $form_result = "";
// $chat_messages = null;
// if ($form->isSuccess()) {
//     global $params;
//     global $form;
//     global $chat_db;
// 	$data = $form->getValues();
// 	$chat_exists = $chat_db->has($data->id);
// 	if ($chat_exists == True) {
//         global $chat_db;
//         global $params;
//         global $data;
//         global $form;
//         // Load chat if it exists
// 		$form = null;
//         $chat_messages = $chat_db->get($data->id)->messages;
// 	} else {
//         global $form;
//         // Create new chat if it doesn't?
// 		$form['id']->addError('That conversation does not exist.');
// 	}
// }
// $params['form_msg'] = $form_msg;

if (isset($_SESSION['chat_id']) == False) {
    // pass
} else {
    global $params;
    global $form;
    global $chat_db;
    $form = null;
	$chat_exists = $chat_db->has($_SESSION['chat_id']);
	if ($chat_exists == True) {
        global $chat_db;
        global $params;
        // Load chat if it exists
        $params['chat_messages'] = $chat_db->get($_SESSION['chat_id'])->messages;
	}
}
// $params['form'] = $form;
$latte->render('templates/chat-view.latte', $params);

?>