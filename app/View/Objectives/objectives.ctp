<script type='text/javascript'>
$(function(){
	$('#add_objective').click(function(e) {
		e.preventDefault();
		$('#popup_overlay, #popup_box').show();
		$('#popup_heading').html($(this).attr('title'));
		$('#popup_content').html('<img src="img/loader.gif"/>').css({'text-align':'center'});
		url = $(this).attr('href');
		$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
			}
		});
	});

	$("#dialog").dialog({
      autoOpen: false,
      modal: true
    });

	$('.delete_obj').click(function(e) {
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
	
	
	$('#popup_close').click(function(){
		$('#popup_overlay, #popup_box').hide();
	});
	
	
		
	$('.edit_objective').click(function(e){
		e.preventDefault();
		$('#popup_overlay, #popup_box').show();
		$('#popup_heading').html($(this).attr('title'));
		$('#popup_content').html('<img src="img/loader.gif"/>').css({'text-align':'center'});
		url = $(this).attr('href');
		$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
				$('.editor').ckeditor(config); 
			}
		});
		
	});

});
	


</script>

<div id='popup_overlay'></div>
<div id='popup_box'>
	<div id='popup_header'>
		<div id='popup_heading'></div>
		<div id='popup_close'>&#10006;</div>
		<div style='clear:both'></div>
	</div>
	<div id='popup_content'></div>
</div>


<div id="dialog" title="Confirmation Required">
  Are you sure to delete this objective?
</div>
<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
<div class="title">
<span class="font-normal">KPI Listing </span>   
</div>
<div class="right"><?php
echo $this->Html->link('Add KPI', 
						'/objectives/add_objective',
						array('class' => 'btn load_ajax pull-right', 'id'=>'add_objective', 'title' => 'Add new KPI')
					);
?></div>
			</h1>														
<table class="table table-bordered">
<thead>
	<tr>
		<th>Name</th>
		<th>Unit</th>
		<th>Description</th>
		<th></th>
		<th></th>
	</tr>
</thead>
	
<tbody>
<?php

foreach($objectives as $objective){
	echo '<tr>';
		echo '<td>'.$objective['Objective']['name'].'</td>';
		echo '<td>'.$objective['Objective']['unit'].'</td>';
		echo '<td>'.$objective['Objective']['description'].'</td>';
		echo '<td>'.$this->Html->link('Edit', '/objectives/editobj/'.$objective['Objective']['id'], array('class'=>'edit_objective', 'title'=>'Edit Objective')).'</td>';
		echo '<td>'.$this->Html->link('Delete', '/objectives/deleteobj/'.$objective['Objective']['id'], array('class'=>'delete_obj')).'</td>';
	echo '</tr>';
}
?>
<!---<tr><td colspan='5'>
<?php
echo $this->Html->link('Add KPI', 
						'/objectives/add_objective',
						array('class' => 'btn load_ajax pull-right', 'id'=>'add_objective', 'title' => 'Add new KPI')
					);
?>
</td>
</tr>------>
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
