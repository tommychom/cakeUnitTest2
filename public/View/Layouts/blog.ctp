<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		BoostCake -
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->Html->css('style');
	?>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
</head>

<body>
	<div id="wrap">
		<div class="container-narrow">
			<div class="masthead">
				<ul class="nav nav-pills pull-right">
	          		<li><?php echo $this->Html->link('Home','/'); ?></li>
		        </ul>
				<h3 class="muted">CakePHP Guideline</h3>
			</div>
			<hr>
			<?php echo $this->fetch('content'); ?>
		</div><!-- /container -->
	<div id="push"></div>
    </div>
	<div id="footer">
      <div class="container-narrow">
        	<p class="pull-right"><a href="#">Back to top</a></p>
        	<p>© 2013 Aware, Corp.</p>
        </div>
	</div>
	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<?php echo $this->fetch('script'); ?>
</body>
</html>