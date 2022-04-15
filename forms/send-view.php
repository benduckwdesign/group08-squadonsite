<?php

use Nette\Forms\Form;

$form = new Form;
$form->addText('message', 'Message')
    ->addRule($form::MIN_LENGTH, 'Message must be at least %d characters.', 1)
    ->addRule($form::MAX_LENGTH, 'Message must be at less than %d characters.', 2000)
    ->setHtmlAttribute('placeholder', "Message...")
    ->setRequired('Please write a message.')
    ->setDefaultValue('');
$form->addSubmit('send', 'Send');
$form->setAction('send-view.php');

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