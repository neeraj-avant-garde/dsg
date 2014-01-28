<script type='text/javascript'>
</script>
<?php
$fields = $planfields['Planfield'];

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


<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
<div class="title">
<span class="font-normal">Edit Business </span>Plan  
</div>
<?php echo $this->Form->create('Planfield', array('editOnePage')); ?>
<div class="right"><div class="pagination pull-right" style='margin:0'>
		<input type='button' class='btn' style='margin:0 5px 5px;' value='save' onclick='this.form.submit();'> 
		<?php echo  $this->html->link('cancel', '/onePgae/', array('class'=>'btn pull-left')); ?>   
	</div></div>
 </h1>

<div>
<!--<div class='well well-small'>-->
	<!--<div class="pagination pull-right" style='margin:0'>
		<input type='button' class='btn' style='margin:0 5px 5px;' value='save' onclick='this.form.submit();'> 
		<?php echo  $this->html->link('cancel', '/planfields/onePgae/', array('class'=>'btn pull-left')); ?>   
	</div>
	
	<div class='clr'></div>--->

</div>		


<table id='edit_one_page_people' class='table table-bordered' >
<thead>
	<tr>
		<th colspan='3'>
			<?php 
				$people = json_decode($fields['people']); 
			?>
			
			<input type='text' value='<?php echo $people->title; ?>' name='people[title]'> <br>
			<input type='text' value='<?php echo $people->subtitle; ?>' name='people[subtitle]'>
			
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<?php
				$emps = $people->employees;
			?>
			<input type='text' value='<?php echo $emps->title; ?>' name='people[employees][title]'> <br>
			<ul class='onepage_list'>
				<?php 
					foreach($emps->names as $emp_name) {
						echo '<li>';
							echo "<input type='text' value='$emp_name' name='people[employees][names][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
		
		<td>
			<?php
				$custs = $people->customers;
			?>
			<input type='text' value='<?php echo $custs->title; ?>' name='people[customers][title]'> <br>
			<ul class='onepage_list'>
				<?php 
					foreach($custs->names as $cust_name) {
						echo '<li>';
							echo "<input type='text' value='$cust_name' name='people[customers][names][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
		
		<td>
			<?php
				$shareholders = $people->shareholders;
			?>
			<input type='text' value='<?php echo $shareholders->title; ?>' name='people[shareholders][title]'> <br>
			<ul class='onepage_list'>
				<?php 
					foreach($shareholders->names as $sh_name) {
						echo '<li>';
							echo "<input type='text' value='$sh_name' name='people[shareholders][names][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
	</tr>
</tbody>

</table>




<table id='edit_one_page_corevalue' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$corevalues = json_decode($fields['corevalues']); 
				// echo $corevalues->title.'<br>';
			?>
			<input type='text' value='<?php echo $corevalues->title; ?>' name='corevalues[title]'>
			<input type='text' value='<?php echo $corevalues->subtitle; ?>' name='corevalues[subtitle]'>
		</th>	
		
		<th>
			<?php	
				$purpose = json_decode($fields['purpose']); 
			 ?>	
			<input type='text' value='<?php echo $purpose->title; ?>' name='purpose[title]'> <br>
			<input type='text' value='<?php echo $purpose->subtitle; ?>' name='purpose[subtitle]'>
		</th>	
		
		<th>
			<?php 
				$targets = json_decode($fields['targets']); 
			?>	
			
			<input type='text' value='<?php echo $targets->title; ?>' name='targets[title]'> <br>
			<input type='text' value='<?php echo $targets->subtitle; ?>' name='targets[subtitle]'>
		</th>

		<th>
			<?php 
				$goals = json_decode($fields['goals']);  
			?>
			<input type='text' value='<?php echo $goals->title; ?>' name='goals[title]'> <br>
			<input type='text' value='<?php echo $goals->subtitle; ?>' name='goals[subtitle]'>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>			
			<ul class='onepage_list'>
				<?php 
					foreach($corevalues->values as $corevalue) {
						echo '<li>';
							echo "<input type='text' value='$corevalue' name='corevalues[values][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
		<td><textarea name='purpose[value]'><?php echo $purpose->value; ?></textarea></td>
		<td>
			<table class='table table-bordered'>
				
				<?php
					foreach($targets->values as $target_name=>$target_value){
						echo '<tr>';
							echo "<td><input type='text' value='$target_name' name='targets[values][$target_name]'></td>" ;
							echo "<td><input type='text' value='$target_value' name='targets[values][$target_value]'></td>" ;
						echo '</tr>';
					}
				?>	
			</table>
		</td>
		<td>
			<table class='table table-bordered'>
				<?php
					foreach($goals->values as $goal_name=>$goal_value){
						echo '<tr>';
							echo "<td><input type='text' value='$target_name' name='goals[values][$goal_name]'></td>" ;
							echo "<td><input type='text' value='$target_value' name='goals[values][$goal_value]'></td>" ;
						echo '</tr>';
					}
				?>	
			</table>
		</td>
	</tr>
</tbody>

</table>




<table id='edit_one_page_sandbox' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$sandbox = json_decode($fields['sandbox']); 
			?>
			<input type='text' value='<?php echo $sandbox->title; ?>' name='sandbox[title]'> <br>
		</th>	
		
		<th>
			<?php 
				$actions = json_decode($fields['actions']); 
			?>
			<input type='text' value='<?php echo $actions->title; ?>' name='actions[title]'> <br>
			<input type='text' value='<?php echo $actions->subtitle; ?>' name='actions[subtitle]'>
		</th>	
		
		<th>
			<?php 
				$capabilities = json_decode($fields['capabilities']); 
			?>
			<input type='text' value='<?php echo $capabilities->title; ?>' name='capabilities[title]'> <br>
			<input type='text' value='<?php echo $capabilities->subtitle; ?>' name='capabilities[subtitle]'>
		</th>

		<th>
			<?php 
				$keyinitiatives = json_decode($fields['keyinitiatives']); 
			?>
			<input type='text' value='<?php echo $keyinitiatives->title; ?>' name='keyinitiatives[title]'> <br>
			<input type='text' value='<?php echo $keyinitiatives->subtitle; ?>' name='keyinitiatives[subtitle]'>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td><textarea name='sandbox[value]'><?php echo $sandbox->value; ?></textarea></td>
		<td>
			<ul class='onepage_list'>
				<?php 
					foreach($actions->values as $value) {
						echo "<input type='text' value='$value' name='actions[values][]'>" ;	
					}
				?>	
			</ul>
		</td>
		<td>
			<ul class='onepage_list'>
				<?php 
					foreach($capabilities->values as $value) {
						echo "<input type='text' value='$value' name='capabilities[values][]'>" ;
					}
				?>	
			</ul>
		</td>
		<td>	
			<ul class='onepage_list'>
				<?php 
					foreach($keyinitiatives->values as $value) {
						echo "<input type='text' value='$value' name='keyinitiatives[values][]'>" ;
					}
				?>	
			</ul>	
		</td>
	</tr>
</tbody>

</table>


<table id='edit_one_page_core' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$corecompetencies = json_decode($fields['corecompetencies']); ; 
			?>
			<input type='text' value='<?php echo $corecompetencies->title ?>' name='corecompetencies[title]'> 
		</th>	
		
		<th>
			<?php 
				$profit = json_decode($fields['profit']); 
			?>
			<input type='text' value='<?php echo $profit->title ?>' name='profit[title]'> 
		</th>	
		
		<th>
			<?php 
				$brand_kpi = json_decode($fields['brand_kpi']); 
			?>
			<input type='text' value='<?php echo $brand_kpi->title ?>' name='brand_kpi[title]'> 
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					foreach($corecompetencies->values as $value) {
						echo "<input type='text' value='$value' name='corecompetencies[values][]'>" ;
					}
				?>	
			</ul>	
		</td>
		<td>
			<textarea name='profit[value]'><?php echo $profit->value; ?></textarea>
			<br>
			<?php $bhag = json_decode($fields['bhag']);  ?>
			
			<h6><?php echo $bhag->title; ?></h6>
			<textarea name='bhag[value]'><?php echo $bhag->value; ?></textarea>
		</td>
		<td>
			<textarea name='brand_kpi[value]'><?php echo $brand_kpi->value; ?></textarea>
			<br>
			
			<?php $brand = json_decode($fields['brand']);  ?>
			<input type='text' name='brand[title]' value='<?php echo $brand->title; ?>' />
			<textarea name='brand[value]'><?php echo $brand->value; ?></textarea>

		</td>
	</tr>
</tbody>

</table>




<table id='edit_one_page_criticals' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$criticalnumbers = json_decode($fields['criticalnumbers']); 
				// echo $criticalnumbers->title;
			?>
			<input type='text' value='<?php echo $criticalnumbers->title; ?>' name='criticalnumbers[title]'> 
		</th>	
	</tr>
	<tr>	
		<th>
			<input type='text' value='<?php echo $criticalnumbers->subtitle ?>' name='criticalnumbers[subtitle]'> 
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					foreach($criticalnumbers->values as $value) {
						echo '<li>';
							echo "<input type='text' value='$value' name='criticalnumbers[values][]'>" ;
						echo '</li>';	
					}
				?>	
			</ul>	
		</td>
	</tr>
</tbody>

</table>

<table id='edit_one_page_swot' class='table table-bordered' >

			<?php $swot = json_decode($fields['swot']); ?>


<tbody>
	<tr>
		<th>
			<?php 
				$strengths = $swot->strengths; 
				echo "<input type='text' value='$strengths->title' name='swot[strengths][title]'>" ;
			?>
			
		</th>
		<th>
			<?php 
				$opportunities = $swot->opportunities; 
				echo "<input type='text' value='$opportunities->title' name='swot[opportunities][title]'>" ;
			?>
		
		</th>
	</tr>	
	
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					foreach($strengths->values as $value) {
						echo '<li>';
							echo "<input type='text' value='$value' name='swot[strengths][values][]'>" ;
						echo '</li>';	
					}
				?>
			</ul>	
		</td>
		
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($opportunities->values as $value) {
						echo '<li>';
							echo "<input type='text' value='$value' name='swot[opportunities][values][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
	</tr>
	
	<tr>
		<th>
			<?php 
				$weaknesses = $swot->weaknesses; 
				echo "<input type='text' value='$weaknesses->title' name='swot[weaknesses][title]'>" ;
			?>
		</th>
		<th>
		<?php 
			$threats = $swot->threats; 
			echo "<input type='text' value='$threats->title' name='swot[threats][title]'>" ;
		?>
		</th>
	</tr>
	
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					foreach($weaknesses->values as $value) {
						echo '<li>';
							echo "<input type='text' value='$value' name='swot[weaknesses][values][]'>" ;
						echo '</li>';
					}
				?>	
				<input type='hidden' value='Weaknesses' name='swot[weaknesses][title]'>
			</ul>	
		</td>
		
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($threats->values as $value) {
						echo '<li>';
							echo "<input type='text' value='$value' name='swot[threats][values][]'>" ;
						echo '</li>';
						$i++;
					}
				?>
					
			</ul>
		</td>
	</tr>
</tbody>

</table>



<table id='edit_one_page_process' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$process = json_decode($fields['process']); 
				
			?>
			<input type='text' value='<?php echo $process->title; ?>' name='process[title]'> <br>
			<input type='text' value='<?php echo $process->subtitle; ?>' name='process[subtitle]'>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<?php
				$make = $process->make;
			?>
			<input type='text' value='<?php echo $make->title; ?>' name='process[make][title]'> <br>
			<ul class='onepage_list'>
				<?php 
					foreach($make->values as $sh_name) {
						echo '<li>';
							echo "<input type='text' value='$sh_name' name='process[make][values][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
			
		</td>
		
		<td>
			<?php
				$sell = $process->sell;
			?>
			<input type='text' value='<?php echo $sell->title; ?>' name='process[sell][title]'> <br>
			<ul class='onepage_list'>
				<?php 
					foreach($sell->values as $sh_name) {
						echo '<li>';
							echo "<input type='text' value='$sh_name' name='process[sell][values][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
		
		<td>
			<?php
				$recordkeeping = $process->recordkeeping;
			?>
			<input type='text' value='<?php echo $recordkeeping->title; ?>' name='process[recordkeeping][title]'> <br>
			<ul class='onepage_list'>
				<?php 
					foreach($recordkeeping->values as $sh_name) {
						echo '<li>';
							echo "<input type='text' value='$sh_name' name='process[recordkeeping][values][]'>" ;
						echo '</li>';
					}
				?>	
			</ul>
		</td>
	</tr>
</tbody>
</table>




<table id='edit_one_page_theme' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$actionsqtr = json_decode($fields['actionsqtr']); 
			?>
			
			<input type='text' value='<?php echo $actionsqtr->title; ?>' name='actionsqtr[title]'> <br>
			<input type='text' value='<?php echo $actionsqtr->subtitle; ?>' name='actionsqtr[subtitle]'>
		</th>
		
		<th>
			<?php
				$theme = json_decode($fields['theme']); 
			?>
			<input type='text' value='<?php echo $theme->title; ?>' name='theme[title]'> <br>
			<input type='text' value='<?php echo $theme->subtitle; ?>' name='theme[subtitle]'>
		</th>

		
		<th>
			<?php
				$celebration = json_decode($fields['celebration']); 
				$reward = json_decode($fields['reward']); 
			?>
			<input type='text' value='<?php echo $celebration->title; ?>' name='celebration[title]'> <br>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<table class='table table-bordered'>
				<?php
					foreach($actionsqtr->values as $qtr_name=>$qtr_value){
						echo '<tr>';
							echo "<td><input type='text' value='$qtr_name' name='actionsqtr[values][$qtr_name]'></td>" ;
							echo "<td><input type='text' value='$qtr_value' name='actionsqtr[values][$qtr_value]'></td>" ;
						echo '</tr>';
					}
				?>	
			</table>
			
		</td>
		
		<td>
			<input type='text' value='<?php echo $theme->theme_name; ?>' name='theme[theme_name]'><br>
			<input type='text' value='<?php echo $theme->theme_value; ?>' name='theme[theme_value]'><br><br>
			
			<input type='text' value='<?php echo $theme->deadline_title; ?>' name='theme[deadline_title]'><br>
			<input type='text' value='<?php echo $theme->deadline_value; ?>' name='theme[deadline_value]'><br>	<br>				
			
			<input type='text' value='<?php echo $theme->measurable_title; ?>' name='theme[measurable_title]'><br>
			<input type='text' value='<?php echo $theme->measurable_value; ?>' name='theme[measurable_value]'><br>	<br>	

		</td>
		
		<td>
			<table class='table table-bordered'>
				<tr>
					<td>
					<textarea name='celebration[value]'><?php echo $celebration->value; ?></textarea>
					</td>
				</tr>
				
				<tr>
					<th><input type='text' value='<?php echo $reward->title; ?>' name='reward[title]'> <br></th>
				</tr>
				<tr>
					<td><textarea name='reward[value]'><?php echo $reward->value; ?></textarea></td>
				</tr>
			</table>
		</td>
	</tr>
</tbody>

</table>

<input type='hidden' value='<?php echo $fields['id'];?>' name='id'>
<?php echo $this->Form->end(); ?>

