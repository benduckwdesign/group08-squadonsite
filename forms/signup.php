<?php

use Nette\Forms\Form;
$form = new Form;
$form->addText('username', 'Username');
$form->addPassword('password', 'Password');
$form->addSubmit('send', 'Sign Up');
$form->setAction('index.php');

?>
