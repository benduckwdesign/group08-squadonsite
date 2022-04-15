<?php

require_once 'vendor/autoload.php';

$latte = new Latte\Engine;

// $latte->setTempDirectory('cache/');

require_once 'forms/login-screen.php';
require_once 'config.php';
require_once 'db/db.php';

$form_msg = "";
$form_result = "";

if (isset($_SESSION['username'])) {
    
    $form_msg = "You are already logged in.";
    global $ROOTURL;
    header("Location: $ROOTURL/news-screen.php");
    die();

} else {

    if ($form->isSuccess()) {
        $data = $form->getValues();
        $user_exists = $user_db->has($data->username);
        if ($user_exists == False) {
            $form['username']->addError('The username or password was incorrect.');
            $form['password']->addError('The username or password was incorrect.');
            // $form_result = var_export($data, true); //debug only
        } else {
            $user = $user_db->get($data->username);
            if ($user->password == $data->password) {
                $form_msg = 'You have been logged in as '.$data->username.'.';
                $_SESSION['username'] = $data->username;
                header("Location: $ROOTURL/news-screen.php");
                die();
            } else {
                $form['username']->addError('The username or password was incorrect.');
                $form['password']->addError('The username or password was incorrect.');
            }
        }
        
    }

}

$params = [
	'siteroot' => $ROOTURL,
	'form' => $form,
	'form_result' => $form_result,
	'form_msg' => $form_msg,
];

$latte->render('templates/login-screen.latte', $params);

?>
