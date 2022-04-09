<?php

use Nette\Forms\Form;

$form = new Form;
$form->addGroup("Join Team");
$form->addText("invite", "Invite ID")
    // ->addRule($form::PATTERN, 'ID must contain letters and numbers only.', '[a-zA-Z0-9]+')
    ->addRule($form::MIN_LENGTH, 'ID must be at least %d characters.', 36)
    ->addRule($form::MAX_LENGTH, 'ID must be no greater than %d characters.', 36);
$form->addSubmit('join', 'Join Team');

$form->addGroup("Create Team");
$form->addText("name", "Team Name");
$form->addSubmit('create', 'Create Team');

$form->setAction('add-team-screen.php');

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