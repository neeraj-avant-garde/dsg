<?php
echo $this->Form->create('Stuck', array('action' => 'add_stuck',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								), 'class' => 'ajx_form'
));

$from = $userModel->read(array('firstname','lastname'),$from);
$from = $from['User']['firstname'].' '.$from['User']['lastname'];
?>
<div class="well">
<div class="list_item"><label>I Need Help From: </label> <input id="userinput" type="text" onkeyup="getuser(this.value);" name="" value='<?php echo $from; ?>'/></div>
<span id="small_loader"><img src="img/loader.gif" width="20px"></span>
<div id="useroutput"></div>
<?php


echo '<div class="list_item"><label>Notes:</label>'.$this->Form->textarea('Stuck.notes',array('type'=>'textarea')).'</div>';
echo $this->form->hidden('Stuck.user_id');
echo $this->form->hidden('Stuck.from', array('id'=>'user_id'));
echo '<div class="list_item">'. $this->Form->submit('submit', array('submit','class'=>'btn', 'value'=>'submit')).'<br></div>';

echo $this->Form->end();
?>	


