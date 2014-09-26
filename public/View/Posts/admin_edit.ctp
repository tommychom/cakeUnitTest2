<?php 
$this->extend('form');
$this->assign('hidden', $this->Form->input('Post.id'));
$this->assign('head', __('Edit Post'));
$this->assign('saveButton', __('Update'));
?>