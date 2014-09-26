<?php 

//extend form.ctp
$this->extend('form');
//assign head parameter to form
$this->assign('head', __('Edit User'));
//assgin button label to form
$this->assign('saveButton', __('Update'));

$this->set('usernameInputOptions', array(
    'disabled' => 'disabled',
    'id' => 'username'
));

$this->set('activeInputOptions',array(
    'type' => 'checkbox',
    'class' => false,
    'before' => '<label>Status</label>',
    'id' => 'active_status'
));
?>