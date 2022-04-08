<?php

require_once 'vendor/autoload.php';

require_once 'config.php';
require_once 'db/db.php';

if (!isset($_SESSION['username'])) { // Die if not logged in
    global $ROOTURL;
    die();
}

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/send-view.php';

$params = [
	'siteroot' => $ROOTURL
];

$form_msg = "";
$form_result = "";
$chat_messages = null;
$params['form_msg'] = $form_msg;
if (isset($_SESSION['chat_id']) == True) {
    if ($form->isSuccess()) {
        global $params;
        global $form;
        global $chat_db;
        global $user_db;
        $data = $form->getValues();
        $chat_exists = $chat_db->has($_SESSION['chat_id']);
        if ($chat_exists == True) {
            global $chat_db;
            global $params;
            global $data;
            global $form;
            global $user_db;
            $chat = $chat_db->get($_SESSION['chat_id']);
            $message = new stdClass;
            $message->username = $_SESSION['username'];
            $message->message = $data->message;
            array_unshift($chat->messages, $message);
            $chat->save();
            
            // alert each user in the conversation
            // for now default to all users
            if ($_SESSION['chat_id'] == "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa") {
                $results = $user_db->findAll();
                foreach ($results as $user) {
                    $user->new_message_notification = true;
                    $user->save();
                }
            }
        } else {
            global $form;
            // Create new chat if it doesn't?
            $form['message']->addError('That conversation does not exist.');
        }
        
    }
} else {
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
            $chat = $chat_db->get($data->id);
            $message = new stdClass;
            $message->username = $_SESSION['username'];
            $message->message = $data->message;
            array_push($chat->messages, $message);
            $chat->save();
        } else {
            global $form;
            // Create new chat if it doesn't?
            $form['message']->addError('That conversation does not exist.');
        }
        
    }
}
$params['form'] = $form;

$latte->render('templates/send-view.latte', $params);

?>