<?php echo $this->Html->script('user_form', array('block' => 'scriptBottom')); ?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">User Management</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $this->fetch('head');  ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
    <?php 
    	echo $this->Form->create('User', array(
    		'inputDefaults' => array(
    			'div' => 'form-group',
          'class' => 'form-control',
          'wrapInput' => 'col',
    		),
        'novalidate' => true
      ));
    	echo $this->Form->input('id');
    ?>
		<?php

      echo $this->Form->input('username', $usernameInputOptions);
      if($this->action == 'admin_edit') {
        echo $this->Form->input('password', array(
        'label' => 'New Password',
        'type' => 'password',
        'id' => 'password',
        'required' => false                              
        ));
        echo $this->Form->input('confirm_password', array(
          'label' => 'Confirm Password',
          'type' => 'password',
          'id' => 'retype_password',
          'required' => false                              
        ));
      } 
      
      echo $this->Form->input('full_name', array(
          'label' => 'Name',
          'id' => 'full_name',
          'div' => 'form-group',
      ));
      echo $this->Form->input('email', array(
         'id' => 'user_email',
        'div' => 'form-group',
      ));
    if (empty($this->data['User']['id']) || $this->data['User']['id'] != AuthComponent::user('id')):
      echo $this->Form->input('group_id', array(
        'type' => 'radio',
        'before' => '<label>Role</label>',
        'legend' => false,
        'options' => array(
            1 => 'Global', 
            2 => 'Local'),
        'class' => 'radio-inline',
        'default' => 1,
        'id' => 'user_role',
        'div' => 'form-group'
      ));
    ?>
    <div class="local_country">
      <?php echo $this->Form->input('countries_id', array(
        'options' => $countries,
        'class' => "multiselect",
        'multiple' => "multiple",
        'id' => 'countries_id',
        'div' => 'form-group',
      ));?>
    </div>
    <?php 
      echo $this->Form->input('active', $activeInputOptions);
      endif;
    ?> 
    <br>
		<div class="form-actions">
			<?php 
				echo $this->Form->submit($this->fetch('saveButton'), array('div' => false, 'class' => 'btn btn-primary')); 
				echo ' ';
				echo $this->Html->link('Cancel', array('action' => 'index'), array('class' => 'btn btn-default')); 
			?>
		</div>
                            <?php echo $this->Form->end(); ?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

