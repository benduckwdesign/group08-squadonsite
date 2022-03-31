<?php

ini_set('include_path', dirname(__FILE__));

$ROOTDIR = null;
$ROOTURL = null;

if(__FILE__ != $_SERVER['SCRIPT_FILENAME']) {

    // include
    global $ROOTDIR;
    global $ROOTURL;

    $any_failure = False;
    $chat_db_writable = is_writable('db/chat_db');
    if ($chat_db_writable == False) {
        global $any_failure;
        $any_failure = True;
        echo "Please make sure db/chat_db is writable for PHP. You can chmod this directory to set write permissions.";
    }
    $site_db_writable = is_writable('db/site_db');
    if ($site_db_writable == False) {
        global $any_failure;
        $any_failure = True;
        echo "Please make sure db/site_db is writable for PHP. You can chmod this directory to set write permissions.";
    }
    $user_db_writable = is_writable('db/user_db');
    if ($user_db_writable == False) {
        global $any_failure;
        $any_failure = True;
        echo "Please make sure db/user_db is writable for PHP. You can chmod this directory to set write permissions.";
    }

    require_once 'db/db.php';

    $ROOTDIR = $site_db->get('rootdir')->dir;
    $ROOTURL = $site_db->get('rooturl')->url;

} else {

    global $ROOTDIR;
    global $ROOTURL;
    
    $any_failure = False;
    $chat_db_writable = chmod('db/chat_db', 0777) || is_writable('db/chat_db');
    if ($chat_db_writable == False) {
        global $any_failure;
        $any_failure = True;
        echo "Please make sure db/chat_db is writable for PHP. You can chmod this directory to set write permissions.";
    }
    $site_db_writable = chmod('db/site_db', 0777) || is_writable('db/site_db');
    if ($site_db_writable == False) {
        global $any_failure;
        $any_failure = True;
        echo "Please make sure db/site_db is writable for PHP. You can chmod this directory to set write permissions.";
    }
    $user_db_writable = chmod('db/user_db', 0777) || is_writable('db/user_db');
    if ($user_db_writable == False) {
        global $any_failure;
        $any_failure = True;
        echo "Please make sure db/user_db is writable for PHP. You can chmod this directory to set write permissions.";
    }

    require_once 'db/db.php';

    // setup
    $rootdir = $site_db->get('rootdir');
    $rootdir->dir = dirname(__FILE__);
    $rootdir->save();

    $rooturl = $site_db->get('rooturl');
    $rooturl->url = dirname('http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
    $rooturl->save();

    $ROOTDIR = $site_db->get('rootdir')->dir;
    $ROOTURL = $site_db->get('rooturl')->url;

    if ($any_failure == False) {
        header("Location: $ROOTURL/signup-screen.php");
        die();
    }

}

?>
