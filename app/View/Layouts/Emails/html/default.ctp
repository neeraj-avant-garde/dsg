<?php
/* 
* Layout for Mails
*/
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

		echo $this->Html->css(array('style'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		

	?>


</head>
<body>
	<!-- Header Start Here -->
	<div class="header">
		<?php echo $this->element('mail_header'); ?>
    </div>
	<!-- Header end Here -->
    
	<!-- Container Start here -->
    <div class="container"> 

		<?php echo $this->fetch('content');	?>
	</div>	
    <!-- Container End here --> 

	
	<!-- Footer Start Here -->
	<div class="footer">
		<?php echo $this->element('mail_footer'); ?>
    </div>
	<!-- footer end Here -->
	
</body>
</html>