<?php
if($this->session->check('Auth.User')){	
	$group = $this->Session->read('Auth.User.Group.id');
	$logged = true;
	if($group==1) {	$admin = true; } 
	if($group==2) {	$user = true; } 
}

?> 
<script>
$(function() {  
   $("#dialog").dialog({
      autoOpen: false,
      modal: true
    });

	$('.userdeleteconfirm').click(function(e) {
		e.preventDefault();
		var targetUrl = $(this).attr("href");
		$("#dialog").dialog({
		  buttons : {
			"Confirm" : function() {
			  window.location.href = targetUrl;
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});

		$("#dialog").dialog("open");		
	});
	
	$('.modify_group').click(function(e){
		e.preventDefault();
		$('#popup_overlay, #popup_box').show();
		$('#popup_heading').html($(this).attr('title'));
		$('#popup_content').html('<img src="<?php echo Router::url('',true); ?>img/loader.gif"/>').css({'text-align':'center'});
		url = $(this).attr('href');
		$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
			}
		});
	});

		
	$('#popup_close').click(function(){
		$('#popup_overlay, #popup_box').hide();
	});
}); 
</script>
<div id='popup_overlay'></div>
<div id='popup_box'>
	<div id='popup_header'>
		<div id='popup_heading'></div>
		<div id='popup_close'>&#10006;	</div>
		<div style='clear:both'></div>
	</div>
	<div id='popup_content'></div>
</div>


<div id="dialog" title="Confirmation Required">
  Are you sure to delete this user?
</div>

<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
<div class="title"><span class="font-normal">Manage </span> Users</div>
<div class="right"><?php
		if($admin && $logged){
			echo $this->Html->link('Add User', '/users/adduser', array('class' => 'btn'));
		}
		?></div>
</h1>
<table class="table table-bordered">
<thead>
	
	<tr>
	<th>Email</th>
	<th>Firstname</th>
	<th>Lastname</th>
	<th></th>
	<th></th>
	<th></th>
	<th></th>
	</tr> 
</thead>
<tbody>
<?php

foreach($users as $user){
	
	echo '<tr>';
		echo '<td>'.$user['User']['email'].'</td>';
		echo '<td>'.$user['User']['firstname'].'</td>';
		echo '<td>'.$user['User']['lastname'].'</td>';
		if($logged && $admin){
			echo '<td class="edit_user" id="row_'.$user['User']['id'].'">';
			echo $this->html->link("Edit", "edit/".$user['User']['id']);
			echo '</td>';
			
			echo '<td class="delete_user" id="row_'.$user['User']['id'].'">';
			echo $this->html->link("Delete", "delete/".$user['User']['id'], array('class'=>'userdeleteconfirm'));
			echo '</td>';
			
			echo '<td class="manage_usergroup" id="row_'.$user['User']['id'].'">';
			echo $this->html->link("Modify user group", "modify_group/".$user['User']['id'], array('class'=>'modify_group','title'=>'Modify Group'));
			echo '</td>';	
			
			echo '<td class="reset_password" id="row_'.$user['User']['id'].'">';
			echo $this->html->link("Reset password", "edit/".$user['User']['id']);
			echo '</td>';
		}
	echo '</tr>';
}
?>
<tr>
	<td colspan='7' align='right'>
	<div class="page">
<?php echo $this->Paginator->prev(' Previous', null, null, array('class' => 'enable')); ?>
<?php echo $this->Paginator->numbers(array('first' => 'First page')); ?>
<?php echo $this->Paginator->next('Next ', null, null, array('class' => 'enable')); ?>
</div>	
	</td>

</tr>

</tbody>
</table>



	
