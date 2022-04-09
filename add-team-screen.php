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

use Ramsey\Uuid\Uuid;

// $latte->setTempDirectory('cache/');

require_once 'forms/add-team-screen.php';

$params = [
	'siteroot' => $ROOTURL,
    'form_msg' => '',
    'form_result' => '',
];

if ($form->isSuccess()) {
    global $params;
    global $form;
    global $user_db;
    global $team_db;
    global $ROOTURL;

    if ($form['create']->isSubmittedBy()) {
        global $form;
        global $user_db;
        global $team_db;
        // global $ROOTURL;
        global $params;

        $data = $form->getValues();
        $user_data = $user_db->get($_SESSION['username']);

        $uuid = Uuid::uuid4();
        $new_team_id = $uuid->toString();

        $new_team = $team_db->get($new_team_id);
        $new_team->id = $new_team_id;
        $new_team->name = $data->name;
        $new_team->owner = $_SESSION['username'];
        $new_team->members = [];
        array_unshift($new_team->members, $_SESSION['username']);
        
        array_unshift($user_data->teams, $new_team->id);

        $new_team->save();
        $user_data->save();

        $params['form_msg'] = "Your new team has been successfully created.";

    }

    if ($form['join']->isSubmittedBy()) {
        global $form;
        global $team_db;
        global $user_db;
        $data = $form->getValues();
        $user_data = $user_db->get($_SESSION['username']);

        if ($team_db->has($data->invite)) {
            global $team_db;
            global $data;
            global $user_db;
            $team = $team_db->get($data->invite);

            if (in_array($_SESSION['username'], $team->members)) {
                $params['form_msg'] = "You are already part of this team.";
            } else {

                array_push($team->members, $_SESSION['username']);
                $user_data = $user_db->get($_SESSION['username']);
                array_unshift($user_data->teams, $team->id);

                $team->save();
                $user_data->save();

                $params['form_msg'] = "You have joined the team via Invite ID.";

            }

        } else {
            global $form;
            $form['invite']->addError("That Invite ID is invalid. Please try again.");
        }

    }
    
}

$params['form'] = $form;

$latte->render('templates/add-team-screen.latte', $params);

?>