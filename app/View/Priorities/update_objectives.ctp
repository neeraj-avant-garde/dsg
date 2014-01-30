<?php 
$q1=$active[0];
$q2=$active[1];
$q3=$active[2];
$q4=$active[3];
?>
<script type='text/javascript'>
$(function(){
	$('#update_obj').click(function() {
		errors = new Array();
		$('.pr_td').each(function(){
			id = this.id;
			current = $('#Priority'+id+'Completed').val();
			target = $('#Priority'+id+'Target').val();
			if((Number(current) > Number(target)) || isNaN(current)){
				errors.push(id);
				$('#Priority'+id+'Completed').next('#msg').html('&#10007').css({'color':'red'});
			} else {
				$('#Priority'+id+'Completed').next('#msg').html('&#10004').css({'color':'green'});
			}
		});

		if(errors.length > 0) {
			var NewDialog = $('<div id="MenuDialog"><p>Current KPI must be less than KPI Target and it must be a number.\
								<br> Please check the red marked KPIs</p></div>');
			NewDialog.dialog({
				modal: true,
				title: "Error",
				buttons: [
					{text: "Ok", click: function() {$(this).dialog("close")}}
				]
			});
			return false;
		}
	});
	
	$("#update_objs li").click(function(){
		$('#update_objs li').removeClass('active');
		$(this).addClass('active');
		
	});
	
	//$('#team_select').val($('#TeamField').val())
	$('#team_select').change(function(){
	    return loadQtrObjs("/priorities/update_objectives/Quarter:"+ $('#quarterIdCont').val() +"?team="+ $(this).val());
	});
});	

</script>

<?php
if($this->session->check('Auth.User')){	
	$group = $this->Session->read('Auth.User.Group.id');
	$user = $this->Session->read('Auth.User');
	$logged = true;
	if($group==1) {	$admin = true; } 
	if($group==2) {	$user = true; } 
}
if($logged){	

?> 
<div class='well well-small'>
<div id='user_filter' class='pull-left'>
	<?php if($admin==true): ?>
	User: <input id="userinput" type="text" onkeyup="get_user(this.value);" name="" />
	<input type='button' value='Go' class='blue_btn' onclick='return loaduserobjs(this.id);' />
	<span id="small_loader"><img src="img/loader.gif" width="20px"></span><br>
	<div id="useroutput"></div>
	<input id="user_id" type="hidden" name="user_id">
	
	<?php endif; ?> 
</div>
<div class="pagination pull-right" style='margin:auto'>
	<ul id='update_objs'>
		<li <?php echo ($activeQtr==$q1)?'class="active"':''; ?>>
			<?php echo $this->Html->link('Q1','/priorities/update_objectives/Quarter:'.$q1.'?team='.$_GET['team'] , array('onclick'=>'$(\'#quarterIdCont\').val(1); return loadQtrObjs("/priorities/update_objectives/Quarter:'.$q1.'?team='.$_GET['team'].'");', 'id'=>'q1')); ?>
		</li>
		<li <?php echo ($activeQtr==$q2)?'class="active"':''; ?>>
			<?php echo $this->Html->link('Q2','/priorities/update_objectives/Quarter:'.$q2.'?team='.$_GET['team'] , array('onclick'=>'$(\'#quarterIdCont\').val(2); return loadQtrObjs("/priorities/update_objectives/Quarter:'.$q2.'?team='.$_GET['team'].'");', 'id'=>'q2')); ?>
		</li>
		<li <?php echo ($activeQtr==$q3)?'class="active"':''; ?>>
			<?php echo $this->Html->link('Q3','/priorities/update_objectives/Quarter:'.$q3.'?team='.$_GET['team'] , array('onclick'=>'$(\'#quarterIdCont\').val(3); return loadQtrObjs("/priorities/update_objectives/Quarter:'.$q3.'?team='.$_GET['team'].'");', 'id'=>'q3')); ?>
		</li>
		<li <?php echo ($activeQtr==$q4)?'class="active"':''; ?>>
			<?php echo $this->Html->link('Q4','/priorities/update_objectives/Quarter:'.$q4.'?team='.$_GET['team'], array('onclick'=>'$(\'#quarterIdCont\').val(4); return loadQtrObjs("/priorities/update_objectives/Quarter:'.$q4.'?team='.$_GET['team'].'");', 'id'=>'q4')); ?>
		</li>
	</ul>
	<input type="hidden" id="quarterIdCont" value="<?php echo $activeQtr ?>" />
</div>
<div class='clr'></div>
    <br />
    <div style="text-align:right">
	<?php
    echo $this->Form->input('field', array('type' => 'select', 'class' => 'te_priority', 'label' => false, 'options' => $dailyHuddle, 'default' => $_GET['team'], 'id'=>'team_select', 'name'=>'team_select'));
	?>
	</div>
</div>
<?php

echo $this->Form->create('Priority', array('action'=>'update_objectives','inputDefaults' => array(
									'label' => false,
									'div' => false)));
?>

<table class='table table-bordered margin1'> 
<thead>
	<tr>
		<th>Quarterly Objective</th>
		<th>Current KPI</th>
		<th>KPI Target</th>
	</tr>
</thead>
<tbody>
<?php
if(!empty($objectives)) {
foreach($objectives as $key => $objective){
	echo '<tr>';
		echo '<td>'.$objective['Priority']['name'].'</td>';
		echo '<td id="'.$key.'" class="pr_td">';
		echo $this->Form->hidden('Priority.'.$key.'.id', array('value'=>$objective['Priority']['id']));
		echo $this->Form->hidden('Priority.'.$key.'.target', array('value'=>$objective['Priority']['target']));
		echo $this->Form->input('Priority.'.$key.'.completed', array('value'=>$objective['Priority']['completed']));
		echo '<span id="msg"></span>';
		echo '</td>';
		echo '<td>'.$objective['Priority']['target'].'</td>';
	echo '</tr>';
}

echo '<tr>';
	echo '<td colspan=3>';
	echo $this->Form->submit('Update', array('class'=>'btn', 'id'=>'update_obj'));
	echo $this->Form->end();
	echo '</td>';
echo '</tr>';
} else {
	echo '<tr>';
	echo '<td colspan=3>';
	echo 'No results found';
	echo '</td>';
	echo '</tr>'; 
}
?>

</tbody>
</table>

<?php } ?>
