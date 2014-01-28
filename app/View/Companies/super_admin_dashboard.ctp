<?php
if($this->session->check('Auth.User')){	
	$group = $this->Session->read('Auth.User.Group.id');
	$logged = true;
	if($group==1) {	$admin = true; } 
	if($group==2) {	$user = true; } 
	if($group==3) {	$superAdmin = true; } 
}
if($superAdmin) {
?> 

<div id='popup_overlay'></div>
<div id='popup_box'>
	<div id='popup_header'>
		<div id='popup_heading'></div>
		<div id='popup_close'>&#10006;</div>
		<div style='clear:both'></div>
	</div>
	<div id='popup_content'></div>
</div>
<h1>
<div class="title">
<span class="font-normal">Manage </span> Companies  
</div>
</h1>
<table class="table table-bordered">
<thead>
	
	<tr>
	<th>Name</th>
	<th>website</th>
	<th>Phone</th>
	<th></th>
	<th></th>
	</tr> 
</thead>
<tbody>
<?php

foreach($companies as $Company){
	echo '<tr>';
			echo '<td>'.$Company['Company']['name'].'</td>';
			echo '<td>'.$Company['Company']['website'].'</td>';
			echo '<td>'.$Company['Company']['phone'].'</td>';
			echo '<td class="edit_company" id="row_'.$Company['Company']['id'].'">';
			echo $this->html->link("Login as Company", "loginAsCompany/".$Company['Company']['id']);
			echo '</td>';
			
			echo '<td class="delete_company" id="row_'.$Company['Company']['id'].'">';
			echo $this->html->link("Delete", "delete_company/".$Company['Company']['id'], array('class'=>'userdeleteconfirm'));
			echo '</td>';
			echo '</td>';	
	echo '</tr>';
}
?>

</tbody>
</table>
<?php echo $this->Paginator->numbers(array('first' => 'First page')); ?>

<?php 
} else {
	$url = Router::url('/dashboard');
	header('Location: '.$url);
	exit;
}
?>


	
