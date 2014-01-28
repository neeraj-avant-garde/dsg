<?php echo $this->element('mail_header'); ?>

<?php
$content = explode("\n", $content);

foreach ($content as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>

<?php echo $this->element('mail_footer'); ?>