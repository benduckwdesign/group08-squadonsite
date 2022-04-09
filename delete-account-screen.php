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
require_once 'forms/delete-account-screen.php';

$params = [
	'siteroot' => $ROOTURL
];

$params['form_msg'] = '';
$params['form_result'] = '';

use Ramsey\Uuid\Uuid;

if ($form->isSuccess()) {
    global $params;
    global $form;
    global $user_db;
    $data = $form->getValues();
    $user_data = $user_db->get($_SESSION['username']);
    if ($data->reason != 0) {
        
        $params['form_msg'] = "Your account will be deleted immediately.";

        header("Location: $ROOTURL/logout-screen.php");
        
        // Easiest way to delete for now is just to lock the user out permanently
        $user_data->password = (Uuid::uuid4())->toString().(Uuid::uuid4())->toString().(Uuid::uuid4())->toString();
        $user_data->email = "";
        $user_data->save();

        // Ideally:
        // Delete the user data
        // Purge user messages from all conversations
        // Reassign owners to other team members, or purge teams with 0 members
        // Keep private records in the scenario bullying needs to be proven, etc.

        die();
    } else {
        $form['reason']->addError("Please select a reason for leaving.");
    }
}

$params['form'] = $form;

$latte->render('templates/delete-account-screen.latte', $params);

?>