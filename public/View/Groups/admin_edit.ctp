<?php 
$this->extend('form');
$this->assign('hidden', $this->Form->input('Group.id'));
$this->assign('head', __('Edit Group'));
$this->assign('saveButton', __('Update'));
?>