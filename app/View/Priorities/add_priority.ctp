<script>
$('[id=PriorityQuarterId]').val($('#qtrid').val())
</script>
<?php
echo $this->Form->create('Priority', array('action' => 'add_priority',
    'inputDefaults' => array(
        'label' => true,
        'div' => false
    ), 'class' => 'ajx_form'
));
?>
<table class='table'>
    <tbody>
        <tr>
            <td class="well">
		
                <?php
                echo $this->Form->input('name', array('type' => 'text', 'placeholder' => 'Objective Name', 'label' => 'Objective Name')) . '<br>';
                $user = $this->session->read('Auth.User');

                if ($user['group_id'] === '1') {
                    echo $this->Form->input('uid', array('type' => 'text', 'onkeyup' => 'getUserByNameAndTeamId(this.value);', 'id' => 'userinput', 'label' => 'Objective Owner', 'autocomplete' => 'off'));
                    echo '<span id="small_loader"><img src="img/loader.gif" width="20px"></span><br>';
                    echo '<div id="useroutput"></div>';
                    echo $this->Form->input('user_id', array('type' => 'hidden', 'id' => 'user_id'));
                } else {
		   
                    echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['id']));
                }



	 //echo $this->Form->input('parent_priority', array('options' => $priorities,'label'=>'Parent Objective')).'<br>';

                echo $this->Form->input('quarter_id', array('options' => $quarter, 'label' => 'Objective Quarter')) . '<br>';


                echo '<h3>Key Progress Indicator  details</h3>';
                $objectives['select'] = 'Select';
                
                echo $this->Form->input('objective_id', array('options' => $objectives, 'label' => 'KPI', 'default' => 'select')) . '<br>';
		echo $this->Form->input('target', array('type' => 'text', 'placeholder' => 'KPI Target', 'label' => 'KPI Target')) . '<br>';
                
		?>
            </td>
        </tr>	
        <tr>
            <td class="well">
                <?php
                echo '<label>Further Explanation</label>';
                echo $this->Form->textarea('comments', array('textarea', 'placeholder' => 'Description')) . '<br><br>';
                echo '<label>Update</label>';
                echo $this->Form->textarea('desc', array('textarea', 'placeholder' => 'Comments')) . '<br>';
                echo $this->Form->input('company_id', array('type' => 'hidden', 'value' => $this->Session->read('current_company')));
                echo $this->Form->submit('Submit', array('submit', 'class' => 'btn', 'value' => 'Submit', 'id' => 'add_priority_submit'));
                echo $this->Form->end();
                ?>	

            </td>
        </tr>
    </tbody>
</table>


