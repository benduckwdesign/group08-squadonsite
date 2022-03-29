<?php

use Nette\Forms\Form;
$form = new Form;
$form->addText('username', 'Name:');
$form->addPassword('password', 'Password:');
$form->addSubmit('send', 'Sign up');
$form->setAction('index.php');

?>
