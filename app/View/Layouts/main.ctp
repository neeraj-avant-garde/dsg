<?php
//die('dfgf');
$title_prefix = 'DSG';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_prefix; ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<!--Removed this file if it's use required i will put it. 'bootstrap.min',-->
	<?php
	
		echo $this->Html->meta('icon');

		echo $this->Html->script('jquery');
echo $this->Html->script(array( 'main'));
?>
<script>
$=jQuery.noConflict();
</script>
<?php
		echo $this->Html->script('http://code.jquery.com/ui/1.10.3/jquery-ui.js');
		echo $this->Html->script(array( 'jquery.mousewheel','ckeditor/ckeditor','ckeditor/jquery', 'ui.multiselect', 'jquery.Jcrop', 'ajaxfileupload','chosen.jquery.min.js'));
		echo $this->Html->css(array( 'style1','styles','cake.generic','ui.multiselect', 'common','jquery.Jcrop','chosen','main.css'));
		
		
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		echo $this->Html->css('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');

		
	?>


</head>
<body>
	<!-- Header Start Here -->
	<!--<div class="header">-->
		<?php echo $this->element('header_inner'); ?>
   <!-- </div>-->
	<!-- Header end Here -->
    
	<!-- Sidebar -->
		<?php //echo $this->element('sidebar'); ?>
	<!--// Sidebar -->
	
	<!-- Container Start here -->
	 <!-- Header end here -->
    
<!-- Footer Start here -->

	<div class="container" id='<?php // echo $this->params['action']; ?>'>
		<?php echo $this->Session->flash();echo $this->Session->flash('auth'); ?>
		<?php echo $this->fetch('content');	?>
	</div>
    <!-- Container End here --> 

	</div>
	<!-- Footer Start Here -->
	<div class="footer">
		<?php echo $this->element('footer_inner'); ?>
    </div>
	<!-- footer end Here -->
	<?php // echo $this->element('sql_dump'); ?>
	
	<script type="text/javascript" src="https://avantgarde.atlassian.net/s/en_US-38181l-1988229788/6080/26/1.4.0-m2/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=94c82371"></script>

</body>
</html>
