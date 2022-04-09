<?php

require_once 'vendor/autoload.php';

// $latte->setTempDirectory('cache/');

require_once 'config.php';
require_once 'db/db.php';

if (!isset($_SESSION['username'])) { // Redirect if not logged in
    global $ROOTURL;
    header("Location: $ROOTURL/login-screen.php");
    die();
}

$latte = new Latte\Engine;
require_once 'forms/settings-screen.php';

$params = [
	'siteroot' => $ROOTURL
];

$params['form_msg'] = '';
$params['form_result'] = '';

if ($form->isSuccess()) {
    global $params;
    global $form;
    global $user_db;
    $data = $form->getValues();
    $user_data = $user_db->get($_SESSION['username']);
    if ($data->password == $user_data->password) {
        if ($data->new_password != "") {
            $user_data->password = $data->new_password;
        }
        $user_data->friend_online_notifications = $data->friend_online_notifications;
        $user_data->team_member_notifications = $data->team_member_notifications;
        $user_data->messages_notifications = $data->messages_notifications;
        $user_data->email = $data->email;
        $user_data->save();
        $params['form_msg'] = "Your settings have been updated.";
    } else {
        $form['password']->addError("This isn't your current password, please try again.");
    }
}

$params['form'] = $form;

$latte->render('templates/settings-screen.latte', $params);

?>