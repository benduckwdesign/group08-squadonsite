<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

$accounts_db = FlatFile::open(dirname(__DIR__).'/db/accounts.qdbm');
$accounts_db->set('db_name', 'accounts');
echo $accounts_db->get('db_name');

?>