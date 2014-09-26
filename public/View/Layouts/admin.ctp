<!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>
		PMI: GAP -
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php
	   echo $this->fetch('meta');
	   echo $this->Html->meta('icon', $this->Html->url('/favicon.ico'));
              echo $this->Html->css('bootstrap.min');
              echo $this->Html->css('font-awesome/css/font-awesome.css');
              echo $this->Html->css('sb-admin');
              echo $this->Html->css('general');
              echo $this->fetch('css');
	?>
        
            <?php 
                echo $this->Html->script('jquery-2.1.0.min');
                echo $this->Html->script('bootstrap.min');
                echo $this->Html->script('plugins/metisMenu/jquery.metisMenu');
                echo $this->Html->script('sb-admin');
                echo $this->Html->script('bootstrap-multiselect');
                echo $this->fetch('script');
             ?>       

</head>
<body> 
	<div id="wrapper">
    	<?php echo $this->element('Layouts/nav_bar'); ?> 
        <?php //echo $this->element('Layouts/left_nav', array(), array('cache' => array('key' => 'left_nav', 'config' => 'short'))); ?> 
        <?php //echo $this->element('Layouts/left_nav'); ?> 
    	<div id="page-wrapper">
	  		<?php echo $this->fetch('content'); ?>
    	</div>
	</div>
	<?php echo $this->fetch('scriptBottom'); ?>
</body>
</html>