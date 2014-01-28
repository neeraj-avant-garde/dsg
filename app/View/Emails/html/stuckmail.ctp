

<h1>Hello <?php echo $to; ?></h1>

<?php
$content = explode("\n", $content);

foreach ($content as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>

