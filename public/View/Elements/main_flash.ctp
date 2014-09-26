<?php if ($this->session->check('Message.flash')): ?>
	<div class="row">
	<?php echo $this->session->flash(); ?>
	</div>
<?php endif; ?>