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

	

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php
    echo $this->fetch('meta');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('font-awesome/css/font-awesome.css');
    echo $this->Html->css('sb-admin');
    echo $this->Html->css('general');
	?>
  <?php 
    echo $this->Html->script('jquery-1.10.2');
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
                    <ul class="nav navbar-top-links navbar-right" id="nav_user">
                        <?php if(AuthComponent::user('id')): ?> 
                        <li >
                                <a class="dropdown-toggle"  href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout'));?>" style="color: #ffffff !important;">
                                    <i class="fa fa-sign-out fa-fw"></i> Log out 
                                </a>            
                        </li>
                        <?php else: ?>
                        <li >
                                <a class="dropdown-toggle"  href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login'));?>" style="color: #ffffff !important;">
                                    <i class="fa fa-user fa-fw"></i> Log in 
                                </a>            
                        </li>
                        <?php endif;?>
                        
                     </ul>                    
                </nav>
		<?php echo $this->fetch('content'); ?>

	</div><!-- /container -->

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	
</body>
</html>