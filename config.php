<?php

// Set to the site root if not set properly automatically. Example: http://localhost/
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
// echo "ROOT: $root <br>";

// Set to the subfolder where the site files are served from the site root. Example: app/
$subfolder = "~be322473/dig4172c/new/";
// echo "SUBDIR: $subfolder <br>";

// This is set to the site root with the subfolder. Example: http://localhost/app/
$siteroot = $root.$subfolder;
// echo "FULLPATH: $siteroot <br>";

?>
