<script type='text/javascript'>
$(function(){
	config = {
		width: 400,
		toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	
		[ 'Cut', 'Copy', 'Paste','Undo', 'Redo' ],																							
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
		]
    };
	
	$('#add_priority').click(function() {
		$('#popup_overlay, #popup_box').show();
		$('#popup_heading').html($(this).attr('title'));
		$('#popup_content').html('<img src="<?php echo IMAGES_URL; ?>/loader.gif" alt="loading.."/> ').css({'text-align':'center'});
		url = $(this).attr('href');
		$.ajax({
			url: url,
			type: "POST",
			dataType: 'text',
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
				$('.editor').ckeditor(config); 
			}
		});
		
		return false;
	});
	
	
	$('#popup_close').click(function(){
		$('#popup_overlay, #popup_box').hide();
	});


});
	



</script>
<?php
$fields = $planfields[0]['Planfield'];
$logged_user = $this->Session->read('Auth.User');

?>



<div id='popup_overlay'></div>
<div id='popup_box'>
	<div id='popup_header'>
		<div id='popup_heading'></div>
		<div id='popup_close'>&#10006;	</div>
		<div style='clear:both'></div>
	</div>
	<div id='popup_content'></div>
</div>


<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
<div class="title">
<span class="font-normal">Business </span>Plan
</div>
 </h1>
<br>
<div class='well well-small' style="margin-top:40px;">
 
	<div class="pagination pull-left" style='margin:0'>
	<?php	
	if($logged_user['group_id']==1) {	
		$named = $this->request->named;
		if(!empty($named)){
			$link = $this->html->link('Edit Business plan', '/planfields/editOnePage/Quarter:'.$named['Quarter'], array('class'=>'btn'));
		} else {
			$link = $this->html->link('Edit Business plan', '/planfields/editOnePage', array('class'=>'btn'));
		}
	}	
	?>
	<?php echo  $link; ?>
	</div>
	<div class="pagination pull-right" style='margin:0'>
		<ul>
			<li <?php echo ($activeQtr==1)?'class="active"':''; ?>><?php echo $this->Html->link('Q1','/planfields/onePage/Quarter:1'); ?></li>
			<li <?php echo ($activeQtr==2)?'class="active"':''; ?>><?php echo $this->Html->link('Q2','/planfields/onePage/Quarter:2'); ?></li>
			<li <?php echo ($activeQtr==3)?'class="active"':''; ?>><?php echo $this->Html->link('Q3','/planfields/onePage/Quarter:3'); ?></li>
			<li <?php echo ($activeQtr==4)?'class="active"':''; ?>><?php echo $this->Html->link('Q4','/planfields/onePage/Quarter:4'); ?></li>
		</ul>
	</div>
	
	<div class='clr'></div>

</div>		


<table id='one_page_people' class='table table-bordered' >
<thead>
	<tr>
		<th colspan='3'>
			<?php 
				$people = json_decode($fields['people']); 
				echo $people->title.'<br>';
				echo '<div class="sub_title">('.$people->subtitle.')</div>'; 
			?>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<?php
				$emps = $people->employees;
			?>
			<div class='inner_title'><?php echo $emps->title; ?></div>
			<ul class='onepage_list'>
				<?php 
					foreach($emps->names as $emp_name) {
						echo '<li>'.$emp_name.'</li>';
					}
				?>	
			</ul>
			
		</td>
		
		<td>
			<?php
				$custs = $people->customers;
			?>
			<div class='inner_title'><?php echo $custs->title; ?></div>
			<ul class='onepage_list'>
				<?php 
					foreach($custs->names as $cust_name) {
						echo '<li>'.$cust_name.'</li>';
					}
				?>	
			</ul>
		</td>
		
		<td>
			<?php
				$shareholders = $people->shareholders;
			?>
			<div class='inner_title'><?php echo $shareholders->title; ?></div>
			<ul class='onepage_list'>
				<?php 
					foreach($shareholders->names as $shareholder_name) {
						echo '<li>'.$shareholder_name.'</li>';
					}
				?>	
			</ul>
		</td>
	</tr>
</tbody>

</table>




<table id='one_page_corevalue' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$corevalues = json_decode($fields['corevalues']); 
				echo $corevalues->title.'<br>';
				echo '<div class="sub_title">('.$corevalues->subtitle.')</div>'; 
			?>
		</th>	
		
		<th>
			<?php	
				$purpose = json_decode($fields['purpose']); 
				echo $purpose->title.'<br>';
				echo '<div class="sub_title">('.$purpose->subtitle.')</div>'; 
			 ?>	
		</th>	
		
		<th>
			<?php 
				$targets = json_decode($fields['targets']); 
				echo $targets->title.'<br>';
				echo '<div class="sub_title">('.$targets->subtitle.')</div>'; 
			?>	
		</th>

		<th>
			<?php 
				$goals = json_decode($fields['goals']);  
				echo $goals->title.'<br>';
				echo '<div class="sub_title">('.$goals->subtitle.')</div>';
			?>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>			
			<ul class='onepage_list'>
				<?php 
					foreach($corevalues->values as $corevalue) {
						echo '<li>'.$corevalue.'</li>';
					}
				?>	
			</ul>
		</td>
		<td> <?php echo $purpose->value; ?></td>
		<td>
			<table class='table table-bordered'>
				
				<?php
					foreach($targets->values as $target_name=>$target_value){
						echo '<tr>';
							echo '<td>'.$target_name.'</td>';
							echo '<td>'.$target_value.'</td>';
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
							echo '<td>'.$goal_name.'</td>';
							echo '<td>'.$goal_value.'</td>';
						echo '</tr>';
					}
				?>	
			</table>
		</td>
	</tr>
</tbody>

</table>




<table id='one_page_sandbox' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$sandbox = json_decode($fields['sandbox']); 
				echo $sandbox->title.'<br>';
			?>
		</th>	
		
		<th>
			<?php 
				$actions = json_decode($fields['actions']); 
				echo $actions->title.'<br>';
				echo '<div class="sub_title">('.$actions->subtitle.')</div>';
			?>
		</th>	
		
		<th>
			<?php 
				$capabilities = json_decode($fields['capabilities']); 
				echo $capabilities->title.'<br>';
				echo '<div class="sub_title">('.$capabilities->subtitle.')</div>';
			?>
		</th>

		<th>
			<?php 
				$keyinitiatives = json_decode($fields['keyinitiatives']); 
				echo $keyinitiatives->title.'<br>';
				echo '<div class="sub_title">('.$keyinitiatives->subtitle.')</div>';
			?>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td><?php echo $sandbox->value; ?></td>
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($actions->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>
		</td>
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($capabilities->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>
		</td>
		<td>	
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($keyinitiatives->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>	
		</td>
	</tr>
</tbody>

</table>


<table id='one_page_core' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$corecompetencies = json_decode($fields['corecompetencies']); ; 
				echo $corecompetencies->title.'<br>';
			?>
		</th>	
		
		<th>
			<?php 
				$profit = json_decode($fields['profit']); 
				echo $profit->title.'<br>';
			?>
		</th>	
		
		<th>
			<?php 
				$brand_kpi = json_decode($fields['brand_kpi']); 
				echo $brand_kpi->title.'<br>';
			?>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($corecompetencies->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>	
		</td>
		<td>
			<?php echo $profit->value; ?>
			<br>

			<?php 	$bhag = json_decode($fields['bhag']);  ?>
			
			<h6>Bhag</h6>
			<?php echo $bhag->value; ?>
		</td>
		<td>
		<?php echo $brand_kpi->value; ?>
		
			<?php 	$brand = json_decode($fields['brand']);  ?>
			<h6><?php echo $brand->title; ?></h6>
			<?php echo $brand->value; ?>
		</td>
	</tr>
</tbody>

</table>




<table id='one_page_criticals' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$criticalnumbers = json_decode($fields['criticalnumbers']); 
				echo $criticalnumbers->title;
			?>
		</th>	
	</tr>
	<tr>	
		<th>
			<?php 
				echo $criticalnumbers->subtitle;
			?>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($criticalnumbers->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>	
		</td>
	</tr>
</tbody>

</table>

<table id='one_page_swot' class='table table-bordered' >

			<?php $swot = json_decode($fields['swot']); ?>


<tbody>
	<tr>
		<th><?php $strengths = $swot->strengths; echo $strengths->title; ?></th>
		<th><?php $opportunities = $swot->opportunities; echo $opportunities->title; ?></th>
	</tr>	
	
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($strengths->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>	
		</td>
		
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($opportunities->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>
		</td>
	</tr>
	
	<tr>
		<th><?php $weaknesses = $swot->weaknesses; echo $weaknesses->title; ?></th>
		<th><?php $threats = $swot->threats; echo $threats->title; ?></th>
	</tr>
	
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($weaknesses->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>	
		</td>
		
		<td>
			<ul class='onepage_list'>
				<?php 
					$i = 1;
					foreach($threats->values as $value) {
						echo '<li>'.$value.'</li>';
						$i++;
					}
				?>	
			</ul>
		</td>
	</tr>
</tbody>

</table>



<table id='one_page_process' class='table table-bordered' >
<thead>
	<tr>
		<th colspan='3'>
			<?php 
				$process = json_decode($fields['process']); 
				echo $process->title.'<br>';
				echo '<small>('.$process->subtitle.')</small>'; 
			?>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<?php
				$make = $process->make;
			?>
			<div class='inner_title'><?php echo $make->title; ?></div>
			<ul class='onepage_list'>
				<?php 
					foreach($make->values as $value) {
						echo '<li>'.$value.'</li>';
					}
				?>	
			</ul>
			
		</td>
		
		<td>
			<?php
				$sell = $process->sell;
			?>
			<div class='inner_title'><?php echo $sell->title; ?></div>
			<ul class='onepage_list'>
				<?php 
					foreach($sell->values as $value) {
						echo '<li>'.$cust_name.'</li>';
					}
				?>	
			</ul>
		</td>
		
		<td>
			<?php
				$recordkeeping = $process->recordkeeping;
			?>
			<div class='inner_title'><?php echo $recordkeeping->title; ?></div>
			<ul class='onepage_list'>
				<?php 
					foreach($recordkeeping->values as $value) {
						echo '<li>'.$value.'</li>';
					}
				?>	
			</ul>
		</td>
	</tr>
</tbody>
</table>




<table id='one_page_theme' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				$actionsqtr = json_decode($fields['actionsqtr']); 
				echo $actionsqtr->title.'<br>';
				echo '<small>('.$actionsqtr->subtitle.')</small>'; 
			?>
		</th>
		
		<th>
			<?php
				$theme = json_decode($fields['theme']); 
				echo $theme->title.'<br>';
				echo '<small>('.$theme->subtitle.')</small>'; 
			?>
		</th>

		
		<th>
			<?php
				$celebration = json_decode($fields['celebration']); 
				$reward = json_decode($fields['reward']); 
				echo $celebration->title.'<br>';
			?>
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
							echo '<td>'.$qtr_name.'</td>';
							echo '<td>'.$qtr_value.'</td>';
						echo '</tr>';
					}
				?>	
			</table>
			
		</td>
		
		<td>
			<?php echo $theme->theme_name; ?><br>
			<?php echo $theme->theme_value; ?><br><br>
			<?php echo $theme->deadline_title; ?><br>
			<?php echo $theme->deadline_value; ?><br>	<br>	

			<?php echo $theme->measurable_title; ?><br>
			<?php echo $theme->measurable_value; ?><br>
		</td>
		
		<td>
			<table class='table table-bordered'>
				<tr>
					<td><?php echo $celebration->value; ?></td>
				</tr>
				
				<tr>
					<th><?php echo $reward->title; ?></th>
				</tr>
				<tr>
					<td><?php echo $reward->value; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</tbody>

</table>




