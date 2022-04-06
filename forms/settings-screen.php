<?php

session_start();

use Nette\Forms\Form;

$form = new Form;
$form->addGroup("Push Notifications");
$form->addCheckbox('game_invite_notifications', 'Game Invites')
    ->setDefaultValue(true);
$form->addCheckbox('friend_online_notifications', 'Friends Online')
    ->setDefaultValue(false);
$form->addCheckbox('team_request_notifications', 'Team Requests')
    ->setDefaultValue(true);
$form->addCheckbox('team_invite_notifications', 'Team Invites')
    ->setDefaultValue(true);
$form->addCheckbox('messages_notifications', 'Messages')
    ->setDefaultValue(true);

$form->addGroup("General");
$form->addSelect("interface", "Interface", ["Dark"])
    ->setDefaultValue(0);
$form->addSelect("language", "Language", ["English"])
    ->setDefaultValue(0);

$form->addGroup("Account");
$form->addEmail("email", "Recovery Email");
if (isset($_SESSION['username'])) {
    // pass
} else {
    header("Location: $ROOTURL/login-screen.php");
    die();
}
$form->addText("username", "Username")
    ->setValue($_SESSION['username'])->setHtmlAttribute('readonly', true);
$form->addPassword("password", "Current Password")
    ->setRequired(true);
$form->addPassword("new_password", "New Password");
$form->addSubmit('send', 'Save');
$form->setAction('settings-screen.php');

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