<?php 
	echo $this->Form->create('Post', array(
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
			echo $this->Form->input('title', array('placeholder' => 'Title', 'class' => 'span6'));
			echo $this->Form->input('category_id');
			echo $this->Form->input('video_link', array('placeholder' => 'Video Link', 'class' => 'span6')); 
			echo $this->Summernote->input('Post.body', array('height' => 150));
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