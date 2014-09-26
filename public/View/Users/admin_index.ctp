<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo __('User Management'); ?></h1>
    </div>
</div>
<div class="">
    <?php echo $this->element('main_flash'); ?>
</div>
<div class="row">
    <div class="text-right">
    <?php echo $this->AclLink->link(
            '<span class="glyphicon glyphicon-plus"></span> '.__('Add'),
            array('admin' => true, 'action' => 'add'), 
            array('class' => 'btn btn-primary','escape' => false)); 
    ?>
    </div>
</div>
<div class="row">
    <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('{:start} - {:end} of {:count}')));
        ?>
    </p>
<?php 
        echo $this->Form->create('User', array(
                'url' => array(
                        'controller' => 'users', 
                        'action' => 'index'
                ),
                'inputDefaults' => array(
                        'label' => false, 
                        'div' => false, 
                        'required' => false, 
                        'class' => 'form-control'
      )));
?>    
<table class="table table-striped table-bordered table-hover">
        <thead>
                <tr>
                        <th><?php echo $this->AwPaginator->sort('User.username', 'Username'); ?></th>
                        <th><?php echo $this->AwPaginator->sort('User.email', 'Email'); ?></th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <tr>
                        <th><?php echo $this->Form->input('User.username'); ?></th>
                        <th><?php echo $this->Form->input('User.email'); ?></th>
                        <th>
                                <?php echo $this->Form->input('User.group_id', array(
                                                'options' => $roles, 
                                                'empty' => '-- All --'));
                                ?>
                        </th>
                        <th>
                                <?php echo $this->Form->input('User.active', array(
                                                'options' => array('Inactive', 'Active'), 
                                                'empty' => '-- All --'));
                                ?>
                        </th>
                        <th><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> Search', array('class' => 'btn btn-info')) ?></th>
                </tr>
        </thead>
        <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5" class="text-center">
                        <h4><?php echo __('Not found any contents.'); ?></h4>
                    </td>
                </tr>
                <?php else:?>
                <?php foreach ($users as $user): ?>
                <tr>
                        <td><?php echo $this->Html->link(
                                                $user['User']['username'], 
                                                array(
                                                        'controller' => 'users', 
                                                        'action' => 'edit', 
                                                        'admin' => true, 
                                                        $user['User']['id']
                                                )); ?>
                        </td>
                        <td><?php echo h($user['User']['email']); ?></td>
                        <td><?php echo h($user['Group']['name']); ?></td>
                        <td class="text-center active-col"><?php echo $this->Aw->booleanToText($user['User']['active']); ?></td>
                        <td class="actions-col">
                                <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-cog"></span> Setting <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu" >
                                        <li>
                                            <?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                                        </li>
                                           <?php $userId = AuthComponent::user('id');
                                                if ($user['User']['id'] != $userId):
                                            ?>      
                                        <li>
                                            <?php echo $this->AclLink->link(__('Delete'), array('action' => 'delete', $user['User']['id']), array() , __('Are you sure you want to delete %s?', $user['User']['username'])); ?>
                                        </li>
                                        <li>
                                            <?php  echo ($user['User']['active'])? $this->AclLink->link(__('Inactive'), array('action' => 'toggleStatus', $user['User']['id'], true), array() , __('Are you sure you want to inactivate user %s?', $user['User']['username'])) :  $this->AclLink->link(__('Active'), array('action' => 'toggleStatus',$user['User']['id']), array() , __('Are you sure you want to activate %s?', $user['User']['username'])) ;?>
                                        </li>
                                        <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                </tr>
                <?php 
                    endforeach; 
                    endif;
                ?>
        </tbody>
</table>
<?php echo $this->Form->end();?>
</div>
<div class="row">
    <?php echo $this->Paginator->pagination(array('ul' => 'pagination pagination-right')); ?>
</div>