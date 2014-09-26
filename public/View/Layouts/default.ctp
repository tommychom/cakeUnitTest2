<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		PMI: GAP -
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<?php
        echo $this->fetch('meta');
        echo $this->Html->meta('icon', $this->Html->url('/favicon.ico'));
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('font-awesome/css/font-awesome.css');
        echo $this->Html->css('sb-admin');
	?>
    <?php 
        echo $this->Html->script('jquery-2.1.0.min');
        echo $this->Html->script('bootstrap.min.js');
        echo $this->Html->script('plugins/metisMenu/jquery.metisMenu');
        echo $this->Html->script('sb-admin.js');
        echo $this->Html->script('jquery.html5support.min');
        echo $this->Html->script('login');
     ?>
</head>

<body>
              
	<div id="wrapper">
                <nav class="navbar navbar-default navbar-static-top"  style="background-color: #0d77bd !important; margin-bottom: 0" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header" >
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Logo Start -->
                        <?php
                            echo $this->Html->image('gap_logo.png', array(
                                'url' => array('controller' => 'posts', 'action' => 'index')
                            ));
                        ?>
                        <!-- Logo End -->
                    </div>
                </nav>
	 <?php echo $this->fetch('content'); ?>

	</div><!-- /container -->
	
</body>
</html>