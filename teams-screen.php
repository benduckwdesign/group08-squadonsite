<?php

$already_submitted = false;

start:

require_once 'vendor/autoload.php';

require_once 'config.php';
require_once 'db/db.php';

if (!isset($_SESSION['username'])) { // Redirect if not logged in
    global $ROOTURL;
    header("Location: $ROOTURL/login-screen.php");
    die();
}


$latte = new Latte\Engine;
require 'forms/teams-screen.php';

// $latte->setTempDirectory('cache/');

$user_data = $user_db->get($_SESSION['username']);
if (is_null($user_data->teams)) {
    global $user_data;
    $user_data->teams = [];
    $user_data->save();
}

$params = [
    'form_msg' => '',
    'form_result' => ''
];

$params['teams'] = [];

if (!empty($user_data->teams)) {
    global $user_data;
    global $team_db;
    global $params;
    $teams = $user_data->teams;
    foreach ($teams as $team_id) {
        global $team_db;
        global $params;
        if ($team_db->has($team_id)) {
            global $params;
            global $team_db;
            $team = $team_db->get($team_id);
            $team_display = [];
            $team_display['name'] = $team->name;
            $team_display['owner'] = $team->owner;
            $team_display['members'] = $team->members;
            $team_display['id'] = $team->id;
            array_unshift($params['teams'], $team_display);
        }
    }
}

if ($form->isSuccess() && $already_submitted == false) {
    global $params;
    global $form;
    global $user_db;
    $data = $form->getValues();
    $user_data = $user_db->get($_SESSION['username']);
    if ($form['leave']->isSubmittedBy()) {

        if (!is_null($data->leave_team_select)) {
            // remove team from user list
            $team_to_leave_id = $params['teams'][$data->leave_team_select]['id'];
            $needle = array_search($team_to_leave_id, $user_data->teams);
            unset($user_data->teams[$needle]);
            $user_data->save();

            // remove user from team members
            if ($team_db->has($team_to_leave_id)) {
                $team = $team_db->get($team_to_leave_id);
                $needle = array_search($_SESSION['username'], $team->members);
                unset($team->members[$needle]);
                $team->save();
            }

            $already_submitted = true;

            goto start;
        }
    }
    if ($form['transfer']->isSubmittedBy()) {

        if (!is_null($data->transfer_team_select)) {
            
            $team_to_transfer_id = $params['teams'][$data->transfer_team_select]['id'];
            $needle = array_search($team_to_transfer_id, $user_data->teams);
            $user_data->teams[$needle]->owner = $data->new_owner;
            $user_data->save();

            // TODO: verification that user exists

            $already_submitted = true;

            goto start;
        }
    }
}

$params['form'] = $form;

$params['siteroot'] = $ROOTURL;

$latte->render('templates/teams-screen.latte', $params);

?>