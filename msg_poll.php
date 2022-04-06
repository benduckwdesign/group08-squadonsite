<?php

require_once 'config.php';
require_once 'db/db.php';

if (isset($_SESSION['username'])) {
    $user_data = $user_db[$_SESSION['username']];
    if ($user_data->has('new_message_notification') == true) {
        // pass
    } else {
        $user_data->new_message_notification = false;
        $user_data->save();
    }
    $refresh == ($user_data->new_message_notification);
    if ($refresh == true) {
        echo "New message.";
        $user_data->new_message_notification = false;
        $user_data->save();
    } else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
} else {
    header("HTTP/1.0 404 Not Found");
    die();
}

?>