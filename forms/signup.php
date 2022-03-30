<?php

use Nette\Forms\Form;
$form = new Form;
$form->addGroup('Registration');
$form->addText('username', 'Username')
    ->addFilter(function ($value) {
        return str_replace(' ', '', $value); // remove spaces from the username
    })
    ->addRule($form::PATTERN, 'Username must contain letters and numbers only.', '[a-zA-Z0-9]+')
    ->addRule($form::MIN_LENGTH, 'Username must be at least %d characters.', 2)
    ->addRule($form::MAX_LENGTH, 'Username must be at less than %d characters.', 32)
    ->setRequired('Please fill in a username.');
$form->addPassword('password', 'Password')
    ->setRequired('Please set a password.')
    ->addRule($form::MIN_LENGTH, 'Password must be at least %d characters.', 8);
$form->addSubmit('send', 'Sign Up');
$form->setAction('index.php');

foreach ($form->getControls() as $control) {
	$control->setOption('class', 'form-'.$control->getOption('type'));
}

$renderer = $form->getRenderer();
$renderer->wrappers['controls']['container'] = '';
$renderer->wrappers['pair']['container'] = 'div';
// $renderer->wrappers['pair']->setOption('class','form-pair');
$renderer->wrappers['label']['container'] = '';
$renderer->wrappers['control']['container'] = '';

?>
