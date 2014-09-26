<?php 
	echo $this->Form->create('Group', array(
		'inputDefaults' => array(
			'div' => 'control-group',
			'label' => array('class' => 'control-label'),
			'wrapInput' => 'controls',
			'required' => false
		),
		'class' => 'well form-horizontal'
	));
	echo $this->fetch('hidden');
?>
	<fieldset>
		<legend><?php echo $this->fetch('head');  ?></legend>
		<?php 
			echo $this->Form->input('name', array('placeholder' => 'Name', 'class' => 'span6'));
		?>
		<div class="form-actions">
			<?php 
				echo $this->Form->submit($this->fetch('saveButton'), array('div' => false, 'class' => 'btn btn-primary')); 
				echo ' ';
				echo $this->Html->link('Cancel', array('action' => 'index'), array('class' => 'btn')); 
			?>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>