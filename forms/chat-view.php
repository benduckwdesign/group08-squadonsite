<?php

use Nette\Forms\Form;

$form = new Form;
$form->addGroup('View Chat');
$form->addText('id', 'Chat ID')
    ->addFilter(function ($value) {
        return str_replace(' ', '', $value); // remove spaces from the username
    })
    ->addRule($form::MIN_LENGTH, 'ID must be at least %d characters.', 36)
    ->addRule($form::MAX_LENGTH, 'ID must be no greater than %d characters.', 36)
    ->setRequired('Please fill in a chat ID.');
$form->addSubmit('send', 'Submit');
$form->setAction('chat-view.php');

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
