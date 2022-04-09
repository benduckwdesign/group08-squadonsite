<?php

use Nette\Forms\Form;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_data = $user_db->get($_SESSION['username']);

if (is_null($user_data->friend_online_notifications)) {
    $user_data->friend_online_notifications = false;
}

if (is_null($user_data->team_member_notifications)) {
    $user_data->team_member_notifications = true;
}

if (is_null($user_data->messages_notifications)) {
    $user_data->messages_notifications = false;
}

$user_data->save();

$form = new Form;
$form->addGroup("Email Alerts");
$form->addCheckbox('friend_online_notifications', 'Friends Online')
    ->setDefaultValue($user_data->friend_online_notifications);
$form->addCheckbox('team_member_notifications', 'New Team Members')
    ->setDefaultValue($user_data->team_member_notifications);
$form->addCheckbox('messages_notifications', 'New Messages')
    ->setDefaultValue($user_data->messages_notifications);

$form->addGroup("General");
$form->addSelect("interface", "Interface", ["Dark"])
    ->setDefaultValue(0);
$form->addSelect("language", "Language", ["English"])
    ->setDefaultValue(0);

$form->addGroup("Account");
if (is_null($user_data->email)) {
    $user_data->email = "";
}
$form->addEmail("email", "Recovery Email")
    ->setDefaultValue($user_data->email);
$form->addText("username", "Username")
    ->setDefaultValue($_SESSION['username'])->setHtmlAttribute('readonly', true);
$form->addPassword("new_password", "New Password");

$form->addGroup("Save Changes");
$form->addPassword("password", "Current Password")
    ->addRule($form::MIN_LENGTH, 'Password must be at least %d characters.', 8)
    ->setRequired(true);
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