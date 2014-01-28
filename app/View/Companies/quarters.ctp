<script type='text/javascript'>
    $(function() {
        $('.qtr_year').val($('#Quarter0StartDate').val());
        $('.qtr_year').each(function() {
            $(this).datepicker({
                changeMonth: true,
                changeYear: false,
                showButtonPanel: false,
                dateFormat: 'yy-mm-dd',
                onSelect: function() {
                    $.ajax({
                        url: '<?php echo Router::url("/"); ?>quarters/set_qtrs/' + $(this).val(),
                        success: function(data) {
                            str = jQuery.parseJSON(data);
                            $('#Quarter0StartDate').val(str[0]);
                            $('#Quarter0EndDate').val(str[1]);
                            $('#Quarter1StartDate').val(str[1]);
                            $('#Quarter1EndDate').val(str[2]);
                            $('#Quarter2StartDate').val(str[2]);
                            $('#Quarter2EndDate').val(str[3]);
                            $('#Quarter3StartDate').val(str[3]);
                            $('#Quarter3EndDate').val(str[4]);
                        }

                    });
                }
            });
        });
    });



</script>

<div id='popup_overlay'></div>
<div id='popup_box'>
    <div id='popup_header'>
        <div id='popup_heading'></div>
        <div id='popup_close'>&#10006;</div>
        <div style='clear:both'></div>
    </div>
    <div id='popup_content'></div>
</div>

<h1><div class="title"><span class="font-normal">Quarters</span> </div></h1>

<?php
echo $this->Form->create('Quarter', array('action' => 'update_quarters', 'inputDefaults' => array(
        'label' => false,
        'div' => false)));
?>																
<table class="table table-bordered">

    <thead>
        <tr>
            <td>Please choose the start date for fiscal year: <input type='text' class='qtr_year'></td>
        </tr>
        <tr>
            <th>Quarter</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
    </thead>

    <tbody>

        <?php
        foreach ($quarters as $key => $quarter) {
            echo '<tr>';
            echo '<td>' . $quarter['Quarter']['name'] . '</td>';
            echo '<td>' . $this->Form->input('Quarter.' . $key . '.start_date', array('value' => $quarter['Quarter']['start_date'], 'class' => 'start_date', "readonly" => "readonly")) . '</td>';
            echo '<td>' . $this->Form->input('Quarter.' . $key . '.end_date', array('value' => $quarter['Quarter']['end_date'], 'class' => 'end_date', "readonly" => "readonly")) . '</td>';
            echo $this->Form->hidden('Quarter.' . $key . '.id', array('value' => $quarter['Quarter']['id']));
            echo '</tr>';
        }
        ?>
        <tr><td colspan='5'>
                <?php
                echo $this->Form->submit('save', array('class' => 'btn'));
                echo $this->Form->end();
                ?>
            </td>
        </tr>	
    </tbody>
</table>
