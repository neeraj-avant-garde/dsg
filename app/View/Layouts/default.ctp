<?php
//die('sdfd');
$title_prefix = 'Dynamic startegy group';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_prefix; ?>:
		<?php echo $title_for_layout; ?>
	</title>
	
	<?php
	
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('cake.generic', 'styles', 'style', 'jquery.bxslider'));
		echo $this->Html->script(array('jquery', 'jquery.mousewheel','ckeditor/ckeditor','ckeditor/jquery', 'jquery.bxslider','jquery.fitvids','jquery.easing.1.3'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		/* Styles and css from cdn*/
		echo $this->Html->css('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
		echo $this->Html->script('http://code.jquery.com/ui/1.10.3/jquery-ui.js');
		echo $this->Html->script('http://twitter.com/javascripts/blogger.js');
	?>


</head>
<body>
	<!-- Header Start Here -->
	<div class="header">
		<?php echo $this->element('header'); ?>
    </div>
	<!-- Header end Here -->
    
	<!-- Container Start here -->
    <div class="container"> 
		<?php echo $this->Session->flash();echo $this->Session->flash('auth'); ?>
		<?php echo $this->fetch('content');	?>
	</div>	
    <!-- Container End here --> 

	
	<!-- Footer Start Here -->
	<div class="footer">
		<?php echo $this->element('footer'); ?>
    </div>
	<!-- footer end Here -->
	<?php // echo $this->element('sql_dump'); ?>
	
	<script type="text/javascript" src="https://avantgarde.atlassian.net/s/en_US-38181l-1988229788/6080/26/1.4.0-m2/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=94c82371"></script>

</body>
</html>
