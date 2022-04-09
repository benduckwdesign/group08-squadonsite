<?php

use Nette\Forms\Form;

$form = new Form;
$form->addGroup("Delete Account");
$form->addSelect("reason", "Reason For Deleting", [
    "Select reason","No longer active in community","Interested in another platform","Harassment","Just think it's time to leave","Other"
])
    ->setRequired(true);
$form->addText("comment", "Additional Comment");
$form->addSubmit('delete', 'Delete Account');

$form->setAction('delete-account-screen.php');

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