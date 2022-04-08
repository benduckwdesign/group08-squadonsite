<?php

require_once 'vendor/autoload.php';

require_once 'config.php';
require_once 'db/db.php';

if (!isset($_SESSION['username'])) { // Redirect if not logged in
    global $ROOTURL;
    header("Location: $ROOTURL/login-screen.php");
    die();
}

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/linked-platforms-screen.php';

$params = [
	'siteroot' => $ROOTURL,
    'form_msg' => '',
    'form_result' => '',
];

$params['form'] = $form;

if ($form->isSuccess()) {
    global $params;
    global $form;
    global $user_db;
    $data = $form->getValues();
    $user_data = $user_db->get($_SESSION['username']);
    $user_data->steam_handle = $data->steam;
    $user_data->discord_handle = $data->discord;
    $user_data->psn_handle = $data->psn;
    $user_data->xbox_handle = $data->microsoft;
    $user_data->twitch_handle = $data->twitch;
    $user_data->youtube_handle = $data->youtube;
    $user_data->twitter_handle = $data->twitter;
    $user_data->save();
    $params['form_msg'] = "Your accounts have been updated successfully.";
}

$latte->render('templates/linked-platforms-screen.latte', $params);

?>