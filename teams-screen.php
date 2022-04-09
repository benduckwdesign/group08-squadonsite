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

$user_data = $user_db->get($_SESSION['username']);
if (is_null($user_data->teams)) {
    global $user_data;
    $user_data->teams = [];
    $user_data->save();
}

$params = [];

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

$params['siteroot'] = $ROOTURL;

$latte->render('templates/teams-screen.latte', $params);

?>