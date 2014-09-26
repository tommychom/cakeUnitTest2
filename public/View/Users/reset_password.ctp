<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Reset Password</h3>
            </div>
            
            <div class="panel-body">
                <?php echo $this->Session->flash(); ?>
                <?php 
                    echo $this->Form->create('User', array(
                            'inputDefaults' => array(
                                    'label' => array('class' => 'control-label'),
                                    'wrapInput' => 'form-group',
                                    'required' => false
                            )
                    ));
                ?>
	<fieldset>
		<?php
                                           echo $this->Form->input('password', array(
                                               'label' => false,
                                               'type' => 'password',
                                               'placeholder' => 'new password',
                                               'id' => 'password',
                                               'class' => 'form-control'
                                           ));
                                           echo $this->Form->input('confirm_password', array(
                                               'label' => false,
                                               'type' => 'password',
                                               'placeholder' => 'retype-password',
                                               'id' => 'retype_password',
                                               'class' => 'form-control'
                                           ));
		?>
            
		<div class="form-actions">
                                <?php 
                                        echo $this->Form->submit('Change Password', array('div' => false, 'class' => 'btn btn-lg btn-success btn-block')); 
                                ?>
		</div>
	</fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>  
</div>

