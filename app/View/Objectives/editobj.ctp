

<?php
echo $this->Form->create('Objective', array('action' => 'editobj',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								), 'class' => 'ajx_form'
));
echo "<div class='form_info'><label>Name</label> ".$this->Form->input('name').'</div>';
echo '<div class="form_info"><label>Description</label> '.$this->Form->textarea('description').'</div>'; 
echo "<div class='form_info'><label>Unit</label> ".$this->Form->input('unit').'</div>';

echo "<div class='form_info'>".$this->Form->submit('submit', array('submit','class'=>'btn', 'value'=>'submit', 'id'=>'add_objective_submit')).'</div>';

echo $this->Form->end();
?>	

