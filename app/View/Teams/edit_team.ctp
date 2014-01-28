

<?php
echo $this->Form->create('Team', array('action' => 'edit_team',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								), 'class' => 'ajx_form'
));
echo "Name ".$this->Form->input('name').'<br>';


?>
<?php /*
<table style='width:50%; float:left; border:1px solid #ccc; ' class='table' id='left_table'>
<thead>

	<tr>
		<th>
			<input class="span2" id="search_user" type="text">	
		</th>
	</tr>
</thead>
<tbody>
	<?php
		$team_users = $this->request->data('User'); 
		$team_user_ids = array();
		foreach($team_users as $t_user) {
			array_push($team_user_ids, $t_user['id']);
		}
		$total_users = array();
		foreach($users as $user){
		$id = $user['User']['id'];	
		$name = $user['User']['firstname'].' '.$user['User']['lastname'];	
		if(!in_array($id, $team_user_ids)) {
		array_push($total_users, $id);	
	?>
	<tr class='left_<?php echo $id; ?>'>
		<td>
			<span id='username'  class='pull-left'><?php echo $name; ?></span>
			<span id='add' class='pull-right' onclick='addUserToTeam(<?php echo $id; ?>,"<?php echo $name?>");'>
				<input type='button' class='btn' value='add'/>
			</span>
		</td>
	</tr>	
	<?php
		} }
	?>
</tbody>
</table>	

<table style='width:50%; float:right; border:1px solid #ccc; border-left:none; ' class='table' id='right_table'>
<thead>
	<tr>
		<th><h4>
			0 items selected 
			Remove all</h4>
		</th>
	</tr>
</thead>
<tbody>
	<?php 
		 for($i=0; $i<=count($total_users); $i++) {
			echo '<tr>';
				echo '<td></td>';
			echo '</tr>';	
		}
	?>
	<tr></tr>
</tbody>
</table>	
<div style='clear:both'></div>

<div id='team_ids' >	
	
</div>
*/?>
<?php
echo $this->Form->input('User.User', array("class" => "multiselect", "multiple" => "multiple", 'options' => $users));
echo $this->Form->submit('submit', array('submit','class'=>'btn', 'value'=>'submit', 'id'=>'add_objective_submit')).'<br>';

echo $this->Form->end();
?>	


