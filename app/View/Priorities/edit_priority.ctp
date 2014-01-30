
<?php
echo $this->Form->create('Priority', array('action' => 'edit_priority',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ), 'class' => 'ajx_form'
));
?>
<table class='table'>
    <tbody>
        <tr>
            <td class="well">
                <?php
                echo '<label>Objective Name</label>';
                echo $this->Form->input('name', array('type' => 'text', 'placeholder' => 'Objective Name')) . '<br>';
                $user = $this->session->read('Auth.User');

                if ($user['group_id'] === '1') {
                    echo '<label>Objective Owner</label>' . $this->Form->input('uid', array('type' => 'text', 'onkeyup' => 'getuser(this.value);', 'id' => 'userinput', 'value' => $users['User']['firstname'] . ' ' . $users['User']['lastname']));
                    echo '<span id="small_loader"><img src="img/loader.gif" width="20px"></span><br>';
                    echo '<div id="useroutput"></div>';
                    echo $this->Form->input('user_id', array('type' => 'hidden', 'id' => 'user_id'));
                } else {
                    echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $user['id']));
                }

				// echo 'Parent Objective ';echo $this->Form->input('parent_priority', array('options' => $priorities)).'<br>';
                echo '<label>Objective Quarter</label>';
                echo $this->Form->input('quarter_id', array('options' => $quarter)) . '<br>';

                echo '<h3>Key Progress Indicator details</h3>';
                echo '<label>KPI</label>';
                echo $this->Form->input('objective_id', array('options' => $objectives)) . '<br>';
                echo '<label>KPI  Target</label>';
                echo $this->Form->input('target', array('text' => array('1', 23, 25), 'placeholder' => 'KPI Target')) . '<br>';
                echo $this->Form->input('completed', array('text' => $this->request->data['Priority']['completed'], 'label' => 'Current KPI')) . '<br>';
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
                echo $this->Form->submit('Submit', array('submit', 'class' => 'btn', 'value' => 'submit', 'id' => 'add_priority_submit')) . '<br>';

                echo $this->Form->end();
                ?>	
            </td>
        </tr>
    </tbody>
</table>

