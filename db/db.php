<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

$user_db = new \Filebase\Database([
    'dir' => 'db/user_db'
]);

?>