

<?php
echo $this->Form->create('Objective', array('action' => 'add_objective',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								), 'class' => 'ajx_form'
));
echo "<div class='form_info'><label>Name</label> ".$this->Form->input('name')."</div>";
echo '<div class="form_info"><label>Description</label> '.$this->Form->textarea('description')."</div>"; 
echo "<div class='form_info'><label>Unit</label> ".$this->Form->input('unit')."</div>";
          
echo $this->Form->submit('submit', array('submit','class'=>'btn', 'value'=>'submit', 'id'=>'add_objective_submit')).'<br>';

echo $this->Form->end();  
?>	   


