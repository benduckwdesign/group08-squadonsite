<?php

use Nette\Forms\Form;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_data = $user_db->get($_SESSION['username']);

$form = new Form;
$form->addGroup("Third-Party Accounts");
$form->addText("steam", "Steam")
    ->setDefaultValue($user_data->steam_handle);
$form->addText("discord", "Discord")
    ->setDefaultValue($user_data->discord_handle);
$form->addText("psn", "PSN")
    ->setDefaultValue($user_data->psn_handle);
$form->addText("microsoft", "Xbox Gamertag")
    ->setDefaultValue($user_data->xbox_handle);
$form->addText("twitch", "Twitch")
    ->setDefaultValue($user_data->twitch_handle);
$form->addText("youtube", "YouTube")
    ->setDefaultValue($user_data->youtube_handle);
$form->addText("twitter", "Twitter")
    ->setDefaultValue($user_data->twitter_handle);
$form->addSubmit('send', 'Save');
$form->setAction('linked-platforms-screen.php');

foreach ($form->getControls() as $control) {
	$control->setOption('class', 'form-'.$control->getOption('type'));
}

$renderer = $form->getRenderer();
$renderer->wrappers['controls']['container'] = '';
$renderer->wrappers['pair']['container'] = 'div';
// $renderer->wrappers['pair']->setOption('class','form-pair');
$renderer->wrappers['label']['container'] = '';
$renderer->wrappers['control']['container'] = '';

?>