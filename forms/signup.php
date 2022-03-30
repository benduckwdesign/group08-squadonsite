<?php

use Nette\Forms\Form;
$form = new Form;
$form->addGroup('Registration');
$form->addText('username', 'Username');
$form->addPassword('password', 'Password');
$form->addSubmit('send', 'Sign Up');
$form->setAction('index.php');

foreach ($form->getPairs() as $pair) {
	$pair->setOption('class', 'form-'.$pair->getOption('type'));
}

$renderer = $form->getRenderer();
$renderer->wrappers['controls']['container'] = 'div';
$renderer->wrappers['pair']['container'] = 'div';
// $renderer->wrappers['pair']->setOption('class','form-pair');
$renderer->wrappers['label']['container'] = 'div';
$renderer->wrappers['control']['container'] = 'div';

?>
