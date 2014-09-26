<div class="row-fluid marketing">
	<div class="span12">
		<h4><?php echo $this->Html->link($post['Post']['title'], '/view/'.$post['Post']['id']); ?></h4>
		<span class="label">by: <?php echo $post['User']['username']; ?> on: <?php echo $this->Time->format('d/m/Y H:i:s', $post['Post']['modified']); ?></span>
		<p class="post">
			<?php echo $post['Post']['body']; ?>
		</p>
	</div>
</div>