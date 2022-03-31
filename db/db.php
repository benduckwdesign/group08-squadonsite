<?php

require_once '/../vendor/autoload.php';

$user_db = new \Filebase\Database([
    'dir' => 'db/user_db'
]);

$chat_db = new \Filebase\Database([
    'dir' => 'db/chat_db'
]);

$site_db = new \Filebase\Database([
    'dir' => 'db/site_db'
]);

?>