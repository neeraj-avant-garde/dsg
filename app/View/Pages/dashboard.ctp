<?php
if($this->session->check('Auth.User')){	
	$group = $this->Session->read('Auth.User.Group.id');
	$user = $this->Session->read('Auth.User');
	$logged = true;
	if($group==1) {	$admin = true; } 
	if($group==2) {	$user = true; } 
}
/* If user is logged in */
if($logged) { 
?>
<h2>Dashboard</h2>
<h3>User Details</h3>


<?php 
} else { 
/* if User not logged in*/	
	header('Location: '.Router::url('/login',true));
}
?>

