<div class="col-lg-12">
	<h1 class="page-header"><?php echo __('Posts'); ?></h1>
</div>
<div class="text-right">
<?php echo $this->AclLink->link(
	'<i class="icon-pencil icon-white"></i> '.__('Add Post'),
	array('admin' => true, 'action' => 'add'), 
	array('class' => 'btn btn-primary','escape' => false)); 
?>
</div>
<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('{:start} - {:end} of {:count}')));
	?>
</p>
<table class="table">
	<tr>
			<th style="width:70%"><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td>
			<div class="media">
              <div class="media-body">
                <h4 class="media-heading"><?php echo h($post['Post']['title']); ?></h4>
                <p class="auto-flow"><?php echo h(strip_tags($post['Post']['body'])); ?></p>
              </div>
            </div>
		</td>
		<td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
		<td class="actions">
			    <div class="btn-group">
			    	<?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $post['Post']['id']), array('class' => 'btn btn-primary')); ?>
			    	<?php echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), array('class' => 'btn btn-danger') , __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
			    </div>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->Paginator->pagination(array('div' => 'pagination pagination-right')); ?>