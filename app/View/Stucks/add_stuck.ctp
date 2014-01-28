<script type="text/javascript"> 
var config = {
  '.chzn-select'           : {},
  '.chzn-select-deselect'  : {allow_single_deselect:true},
  '.chzn-select-no-single' : {disable_search_threshold:10},
  '.chzn-select-no-results': {no_results_text:'Oops, nothing found!'},
  '.chzn-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>

<?php
echo $this->Form->create('Stuck', array('action' => 'add_stuck',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								), 'class' => 'ajx_form'
));
?>
<div class="well">
<div class="list_item"><label>I Need Help From:</label><input id="userinput" type="text" onkeyup="getuser(this.value);" name="" /></div>
<span id="small_loader"><img src="img/loader.gif" width="20px"></span>
<div id="useroutput"></div>
<?php


echo '<div class="list_item"><label>Notes:</label>'.$this->Form->textarea('Stuck.notes',array('type'=>'textarea')).'</div>';
echo $this->form->hidden('Stuck.user_id', array('value'=>$this->session->read('Auth.User.id'), 'id'=>'userid'));
echo $this->form->hidden('Stuck.from', array('id'=>'user_id'));
echo $this->form->hidden('Stuck.company_id', array('value'=>$this->Session->read('current_company')));

/* echo $this->form->input('from', array(
									'id'=>'user_id',
									'options'=>$users,
									'data-placeholder'=>"Your Favorite Types of Bear",
									'multiple' => 'multiple',
									'class' => "chzn-select", 
									'tabindex' =>  "8"
								)); */

echo '<div class="list_item">'.$this->Form->submit('Submit', array('submit','class'=>'btn', 'value'=>'submit')).'<br></div></div>';

echo $this->Form->end();
?>	



