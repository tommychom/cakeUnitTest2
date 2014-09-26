<div class="row">
    <div class="col-md-4 col-md-offset-4" style="min-width: 490px !important;">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Forgot Password ?</h3>
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
                    echo $this->Form->input('email', array(
                                'label' => 'Enter you email address',
                                'placeholder' => 'email',
                                'class' => 'form-control'
                            ));
	?>
                <div class="row form-group" style="padding-left: 8px;">
                <?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => 'clean')));?>
                </div>
                    <div class="form-actions">
                            <?php 
                                    echo $this->Form->submit('Submit', array('div' => false, 'class' => 'btn btn-lg btn-success btn-block')); 
                            ?>
                    </div>
	</fieldset>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>  
</div>

