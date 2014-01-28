<?php //pr($redit); ?>
<table class='table'>
<tbody>
<tr>

<td class="well">
<form name="teamedit" action="<?php echo Router::url("/"); ?>teams/teamupdate/" method="POST">
<label class="team_tab">Objective</label>
	<input type="text" name="objective" value="<?php echo $redit[0]['priorities']['name'];?>" class="in_team"/><br>

	<label class="team_tab">Assigned To</label>
	 <input type="text" name="assigned" value="<?php echo $redit[0]['users']['firstname'] .''.$redit[0]['users']['lastname'] ;?>" class="in_team"/><br>

	<label class="team_tab">Completed</label>
<?php $completed = $redit[0]['priorities']['completed'];
$target = $redit[0]['priorities']['target'];
 ?>
	<input type="text" name="completed" value="<?php echo $completed/$target ;?>" class="in_team"/><br>
	
	<label class="team_tab">Updated</label>
	<input type="text" name="updated" value="<?php echo $redit[0]['priorities']['modified'];?>" class="in_team"/>

	<input type="hidden" name="priorityid" value="<?php echo $redit[0]['priorities']['id'];?>"/>
	<input type="hidden" name="teamid" value="<?php echo $redit[0]['team_users']['team_id'];?>"/> 							
	<input type="submit" name="submit" value="submit" class="team_btn"/>
</form>
</td>
</tr>
