<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Please Sign In</h3>
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
			echo $this->Form->input('username', array(
                                                'label' => false,
                                                'placeholder' => 'username',
                                                'class' => 'form-control'
                                            ));
			echo $this->Form->input('password', array(
                                                'label' => false,
                                                'placeholder' => 'password',
                                                'class' => 'form-control'
                        ));
		?>
            <div class="row">
                <div class="col-lg-12">
                <p style='text-align: right'>
                            <?php echo $this->Html->link('Forgot Password ?', array(
                                'controller' => 'users',
                                'action' => 'forgotPassword'
                            ),
                                    array('class' => 'text-muted'));
                            ?>
                </p>
                </div>
            </div>
		<div class="form-actions">
			<?php 
				echo $this->Form->submit('Login', array('div' => false, 'class' => 'btn btn-lg btn-success btn-block')); 
			?>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>  
</div>

