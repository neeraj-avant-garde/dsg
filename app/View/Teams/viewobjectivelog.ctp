<?php 
if(empty($logs)){
	die("No Logs found for this objective");
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ObjectiveId</th>
            <th>Completed</th>
			<th>Target</th>	
			<th>Last Modified</th>	
			<th>Modified By</th>	
        </tr>
    </thead>
	
	<tbody>
	<?php 
		foreach($logs as $log){
			
			echo "<tr>";
			echo "<td>".$log['objectivelogs']['objective_id']."</td>";			
			echo "<td>".$log['objectivelogs']['completed']."</td>";			
			echo "<td>".$log['objectivelogs']['target']."</td>";			
			echo "<td>".date('M,d,Y h:i:s', strtotime($log['objectivelogs']['modified']))."</td>";		
			$user = $userModel->find('first', array('fields'=>array('firstname','lastname'), 'conditions'=>array('User.id'=>$log['objectivelogs']['modified_by'])));
			echo "<td>".$user['User']['firstname'].' '.$user['User']['lastname']."</td>";			
			
			echo "</tr>";
		}
	?>	
	</tbody>
</table>