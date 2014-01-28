<?php
if($this->session->check('Auth.User')){	
	$group = $this->Session->read('Auth.User.Group.id');
	$user = $this->Session->read('Auth.User');
	$user_id = $user['id'];
	$logged = true;
	if($group==1) {	$admin = true; } 
	if($group==2) {	$noarmal_user = true; } 
}
/* If user is logged in */
if($logged) { 
?>
<?php

	echo $this->Html->script(array( 'prototype', 'raphael-min', 'grafico.min','justgage.1.0.1.min'));

?>
<script type='text/javascript'>

$(function(){
	config = {
		toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	
		[ 'Cut', 'Copy', 'Paste','Undo', 'Redo' ],																							
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
		]
    };
	$('.editor').ckeditor(config);
	
	$('#dailypriority').click(function(){
		$('#dailypriority_editform').show();
		$(this).hide();
	});
	
	$('#hideDiv').click(function(){
		$("#dailypriority_editform").hide(); $("#dailypriority").show(); 
	});
	
	
});

window.onload = function(){
	var linegraph3 = new Grafico.LineGraph($p('graph'),
	{
	  workload:       [8, 10, 6, 12,7, 6, 9],
	  your_workload:  [6, 8,  4, 8, 12,6, 2],
	  his_workload:   [2, 9,  12,7, 8, 9, 8]
	},
	{
	  markers:            "circle",
	  hover_color:        "#000",
	  hover_text_color:   "#fff",
	  watermark_location: "middle",
	  draw_hovers:        true,
	  datalabels: {
		workload:         "My workload",
		your_workload:    "Your workload",
		his_workload:     "His workload"
	  }
	});
}
function gauge(completed, target, id){
	var total = Math.ceil((completed/target) * 100);
	color = 'red';
	if(total <= 25 && total > 0){
		color = 'red';
	}	

	if(total <= 50 && total > 25){
		color = 'orange';
	}
	
	if(total <= 75 && total > 50){
		color = 'yellow';
	}		
	
	if(total < 100 && total > 75){
		color = '#A2BE2B';
	}
	
	if(total == 100){
		color = 'green';
	}

	
	var g = new JustGage({
		id: id,
		value: total,
		min: 0,
		title: ' ',
		max: 100,
		levelColors: [ color ],
		showMinMax: false,
		label: 'Completed',
		labelFontColor: '#000',
		gaugeWidthScale: 0.5
	});
}



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
<h1 class="list_tit"><i class="icon"><img src="<?php echo Router::url('/'); ?>images/Untitled-2.png"/></i><div class="title"><span class="font-normal">Objective</span> status</div></h1>



<div id='graph' class="dashboard_graph" style='height:367px; width:1000px; margin:0px auto'></div>

<?php 
$criticalnumbers = json_decode($criticalnumbers['Planfield']['criticalnumbers']); 
?>
 
<table id='dashboard_criticals' class='table table-bordered' >
<thead>
	<tr>
		<th>
			<?php 
				echo $criticalnumbers->title;
			?>
		</th>	
	</tr>
	<tr>	
		<th>
			<?php 
				echo $criticalnumbers->subtitle;
			?>
			<div class="pagination pull-right" style='margin:0'>
				<ul>
					<li <?php echo ($activeQtr==1)?'class="active"':''; ?>><?php echo $this->Html->link('Q1','/companies/dashboard/Quarter:1'); ?></li>
					<li <?php echo ($activeQtr==2)?'class="active"':''; ?>><?php echo $this->Html->link('Q2','/companies/dashboard/Quarter:2'); ?></li>
					<li <?php echo ($activeQtr==3)?'class="active"':''; ?>><?php echo $this->Html->link('Q3','/companies/dashboard/Quarter:3'); ?></li>
					<li <?php echo ($activeQtr==4)?'class="active"':''; ?>><?php echo $this->Html->link('Q4','/companies/dashboard/Quarter:4'); ?></li>
				</ul>
			</div>
		</th>	
	</tr>
</thead>

<tbody>
	<tr>
		<td>
			<ul class='onepage_list'>
				<?php 
					if(!empty($criticalnumbers->values))
{
					foreach($criticalnumbers->values as $value) {
						if($value!=='') {
							echo '<li>'.$value.'</li>';
						} else {
							echo "<li>You don't have any critical numbers yet</li>";
							break;
						}
					}
}
				?>	
			</ul>	
		</td>
	</tr>
</tbody>

</table>


<table class='table table-borderd'>

<thead>
	<!--<tr><th>My top priority for the day</th></tr>-->
</thead>
<tbody>
	<tr>
	<td>
		<div id='dailypriority'>
			<?php

				$today_priority = $dailyModel->find('first',array('conditions'=>array(
														'user_id'=>$user['id'],
														'created LIKE ' => '%'.date('Y-m-d').'%'
														
													)));
				$task = $today_priority['Dailypriority']['task'];	
				if(!empty($task)){
					echo $task;
				} else {
					echo 'A top priority has not been entered.';
				}
				
			?>
		</div>
		
		<div id='dailypriority_editform' style='display:none'>
			<?php 

				echo $this->Form->create('Dailypriority', array('action'=>'edit_dailypriority')); 
				echo $this->Form->textarea('task', array('class'=>'editor', 'value'=>$today_priority['Dailypriority']['task']));
				echo $this->Form->input('user_id', array('type'=>'hidden', 'value'=>$user['id']));
				echo $this->Form->input('created_date', array('type'=>'hidden', 'value'=> date('Y-m-d')));
				echo $this->Form->input('id', array('type'=>'hidden', 'value'=>$today_priority['Dailypriority']['id']));
				echo $this->Form->submit('save',array('class'=>'btn'));
				echo $this->Form->button('cancel', array(
														'class'=>'btn',
														'value'=>'cancel',
														'id' => 'hideDiv',
														'type'=>'button'
														)
										);
				echo $this->Form->end();
			?>
		</div>
	</td>
	</tr>
</tbody>

</table>


<?php 
	$userPriorities = $Priority->find('all',array(
											'fields'=> array('target','completed', 'name'), 
											'conditions'=>array('user_id'=>$user_id),
											'order' =>'Priority.created DESC',
											'limit' => 4
										));
	$firstP = $userPriorities[0]['Priority'];
	$secondP = $userPriorities[1]['Priority'];
	$thirdP = $userPriorities[2]['Priority'];
	$fourthP = $userPriorities[3]['Priority'];
?>
 <div class="container">
    	<div class="left_col">
        	<h1 class="list_tit"><i class="icon"><img src="<?php echo Router::url('/'); ?>images/user.png"/></i><div class="title"><span class="font-normal"><?php echo $user['firstname']; ?>’s</span> Priority</div></h1>
            <div class="grey_div">
			<!--<div class='pull-left' style='width:70%'>-->
			<div class='pull-left' style="float:left;width:217px;">
		<?php if(!empty($firstP)){ ?>
		<!--width:350px; height:230px;margin-left:-100px;-->
			<div id='firstgauge'></div>	
			<h4><?php echo $firstP['name']; ?></h4>
			<script type='text/javascript'> gauge(<?php echo $firstP['completed']; ?>, <?php echo $firstP['target']; ?>, 'firstgauge'); </script>	
		<?php } ?>
	</div>
	
	<!--<div class='pull-right' style='width:30%;'>-->
	<div class='pull-right' style="float:right;width:139px; margin-top: 26px;">
		<?php if(!empty($secondP)){ ?> 
				<div id='secondgauge' style='width:150px; height:120px;'></div>	
				<h6><?php echo $secondP['name']; ?></h6>
				<script type='text/javascript'> gauge(<?php echo $secondP['completed']; ?>, <?php echo $secondP['target']; ?>, 'secondgauge'); </script>	
		<?php } ?>	
		
		<?php if(!empty($thirdP)){ ?>
				<div id='thirdgauge' style='width:150px; height:120px;'></div>	
				<h6><?php echo $thirdP['name']; ?></h6>
				<script type='text/javascript'> gauge(<?php echo $thirdP['completed']; ?>, <?php echo $thirdP['target']; ?>, 'thirdgauge'); </script>	

		<?php } ?>

		<?php if(!empty($fourthP)){ ?> 
			<div id='fourthgauge' style="width:150px; height:120px"></div>	
			<h6><?php echo $fourthP['name']; ?></h6>
			<script type='text/javascript'> gauge(<?php echo $fourthP['completed']; ?>, <?php echo $fourthP['target']; ?>, 'fourthgauge'); </script>	
		<?php } ?>
	</div>
	
	<div class='clr'></div>
            	
            </div>
        </div>
        
        <!--<div class="right_col">
        	<h1 class="list_tit"><i class="icon"><img src="<?php echo Router::url('/'); ?>images/Untitled-1.png"/></i><div class="title"><span class="font-normal">To Do</span> list</div></h1>
            <div class="grey_div">
            	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.</p>
                <hr />
                <div class="to_do_list scrollpanel">
                	<div class="list_blog">
                    	<img src="images/user_img.gif" alt="" class="list_img" />
                        <span class="list_detail">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.<br />
                            <a href="#" class="red_btn left">View Details</a>
                        </span>
                    </div>
                    
                    <div class="list_blog">
                    	<img src="images/user_img.gif" alt="" class="list_img" />
                        <span class="list_detail">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.<br />
                            <a href="#" class="red_btn left">View Details</a>
                        </span>
                    </div>
                    
                    <div class="list_blog">
                    	<img src="images/user_img.gif" alt="" class="list_img" />
                        <span class="list_detail">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.<br />
                            <a href="#" class="red_btn left">View Details</a>
                        </span>
                    </div>
                    
                    <div class="list_blog">
                    	<img src="images/user_img.gif" alt="" class="list_img" />
                        <span class="list_detail">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.<br />
                            <a href="#" class="red_btn left">View Details</a>
                        </span>
                    </div>
                    
                    <div class="list_blog">
                    	<img src="images/user_img.gif" alt="" class="list_img" />
                        <span class="list_detail">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.<br />
                            <a href="#" class="red_btn left">View Details</a>
                        </span>
                    </div>
                    
                    <div class="list_blog">
                    	<img src="images/user_img.gif" alt="" class="list_img" />
                        <span class="list_detail">
                        	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.<br />
                            <a href="#" class="red_btn left">View Details</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>-->
 </div>
 
 
	<div class="container">
    	<h1 class="list_tit"><i class="icon"><img src="<?php echo Router::url('/'); ?>images/Untitled-3.png"/></i><div class="title"><span class="font-normal">My</span> Stucks</div></h1>
        <div class="grey_div">
        	<p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris. Donec vitae nibh felis, facilisis bibendum sapien.
            </p>
            <hr />
            
            		<div class="tabs">
                    	<ul>
                        	<li><a href="#" class="active">I am Stuck</a></li>
                            <li><a href="#">I am Holding</a></li>
                        </ul>
                    </div>
            <div class="stucks_col scrollpanel">
                	<table cellpadding="0" cellspacing="0" border="0">
                    	<tr>
                        	<th width="60%">Stuck Description</th>
                            <th>Person Stuck</th>
                            <th>Since</th>
                        </tr>
                        <tr>
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr class="alt">
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr>
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr class="alt">
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr>
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr class="alt">
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr>
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                        <tr class="alt">
                        	<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae accumsan mauris.</td>
                            <td>Daniel</td>
                            <td>2 hour</td>
                        </tr>
                    </table>
                </div>
        </div>
    </div>

<?php 
} else { 
/* if User not logged in*/	
	header('Location: '.Router::url('/login',true));
}
?>

