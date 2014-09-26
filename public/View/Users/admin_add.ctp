
<?php
//extend form.ctp 
$this->extend('form');
//assign head parameter to form
$this->assign('head', __('Add User'));
//assgin button label to form
$this->assign('saveButton', __('Save'));

$this->set('usernameInputOptions', array(
    'id' => 'username'
));

$this->set('activeInputOptions',array(
    'type' => 'checkbox',
    'class' => false,
    'before' => '<label>Status</label>',
    'id' => 'active_status',
    'checked' => true
));

?>