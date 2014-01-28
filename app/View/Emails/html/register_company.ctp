

<h4>Hello <?php echo $to; ?></h4>
Here is your Login Details: <br>
Username: <?php echo $to; ?> <br>
Password: <?php echo $password; ?> <br><br>



<?php
$content = explode("\n", $content);

foreach ($content as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>

