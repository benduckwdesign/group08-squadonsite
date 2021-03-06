<?php

require_once 'vendor/autoload.php';

$user_db = new \Filebase\Database([
    'dir' => 'db/user_db'
]);

$chat_db = new \Filebase\Database([
    'dir' => 'db/chat_db',
    'validate' => [
        'messages' => [
            'valid.type' => 'array',
            'valid.required' => true,
            'username' => [
                'valid.type' => 'string',
                'valid.required' => true
            ],
            'message' => [
                'valid.type' => 'string',
                'valid.required' => true
            ],
        ]
    ]
]);

$site_db = new \Filebase\Database([
    'dir' => 'db/site_db'
]);

$team_db = new \Filebase\Database([
    'dir' => 'db/team_db'
]);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>