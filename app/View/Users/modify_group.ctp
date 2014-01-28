<?php
echo $this->Form->create('User', array('action'=>'modify_group','inputDefaults' => array(
									'label' => false,
									'div' => false)));
echo "<div class='form_info'>".$this->Form->input('group_id', array('options' => $groups));
echo $this->Form->submit('Submit',array('class'=>'btn pull-left'))."</div>";     
echo $this->end();									
									

?>