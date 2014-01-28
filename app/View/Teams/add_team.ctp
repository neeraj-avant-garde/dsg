

<?php
echo $this->Form->create('Team', array('action' => 'add_team',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								), 'class' => 'ajx_form'
));
echo "<div class='form_info'>Name ".$this->Form->input('name').'</div>';
?>


<?php

echo $this->Form->input('User.User', array("class" => "multiselect", "multiple" => "multiple", 'options' => $users));

echo $this->Form->input('company_id', array('type'=>'hidden', 'value'=>$this->Session->read('current_company'))).'<br>';
echo $this->Form->submit('submit', array('submit','class'=>'btn', 'value'=>'submit', 'id'=>'add_objective_submit')).'<br>';

echo $this->Form->end();
?>	


