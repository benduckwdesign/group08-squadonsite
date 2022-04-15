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

if (is_null($user_data->teams)) {
    $user_data->teams = [];
}

$user_data->save();

$form = new Form;

$team_displays = [];
$team_displays_owned = [];
if (!empty($user_data->teams)) {
    global $user_data;
    global $team_db;
    global $team_displays;
    global $team_displays_owned;
    $teams = $user_data->teams;
    foreach ($teams as $team_id) {
        global $team_db;
        global $team_displays;
        global $team_displays_owned;
        if ($team_db->has($team_id)) {
            global $team_db;
            global $team_displays;
            global $team_displays_owned;
            $team = $team_db->get($team_id);
            array_unshift($team_displays, $team->name);
            if ($team->owner == $_SESSION['username']) {
                global $team_db;
                array_unshift($team_displays_owned, $team->name);
            }
        }
    }
}

$form->addGroup("Leave Team");
$form->addSelect('leave_team_select', 'Team', $team_displays);
$form->addSubmit('leave', 'Leave');

$form->addGroup("Transfer Ownership");
$form->addSelect('transfer_team_select', 'Team', $team_displays_owned);
$form->addText('new_owner', 'New Owner')
    ->addFilter(function ($value) {
        return str_replace(' ', '', $value); // remove spaces from the username
    })
    ->addRule($form::PATTERN, 'Username must contain letters and numbers only.', '[a-zA-Z0-9]+')
    ->addRule($form::MAX_LENGTH, 'Username must be at less than %d characters.', 32);
$form->addSubmit('transfer', 'Transfer');

$form->setAction('teams-screen.php');

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