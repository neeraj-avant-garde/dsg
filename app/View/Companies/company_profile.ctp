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
                            $('#Quarter0StartDate').val(str[1]['start_date']);
                            $('#Quarter0EndDate').val(str[1]['end_date']);
                            $('#Quarter1StartDate').val(str[2]['start_date']);
                            $('#Quarter1EndDate').val(str[2]['end_date']);
                            $('#Quarter2StartDate').val(str[3]['start_date']);
                            $('#Quarter2EndDate').val(str[3]['end_date']);
                            $('#Quarter3StartDate').val(str[4]['start_date']);
                            $('#Quarter3EndDate').val(str[4]['end_date']);
                        }

                    });
                }
            });
        });
    });
</script>


<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
    <div class="title">
        <span class="font-normal">Company </span> Profile 
    </div>
</h1>
<?php
$company = $this->request->data['Company'];
?>

<table class='table table-bordered'>
    <tbody>
        <tr><th>Name:</th><td> <?php echo $company['name']; ?> </td></tr>
        <tr><th>Phone:</th><td> <?php echo $company['phone']; ?> </td></tr>
        <tr><th>Web site:</th><td> <?php echo $company['website']; ?> </td></tr>
        <tr><th>Bussiness Type:</th> <td><?php echo $company['bus_type']; ?> </td></tr>
        <tr><td colspan='2'><?php echo $this->html->link('Edit company Info', '/companies/edit_company/', array('class' => 'btn')); ?></td> </tr>
    </tbody>
</table>

<?php
echo $this->Form->create('Quarter', array('action' => 'update_quarters','name'=>'', 'inputDefaults' => array(
        'label' => false,
        'div' => false)));
?>																
<table class="table table-bordered">

    <thead>
        <tr>
            <td colspan='3'>
                Please choose the start date for fiscal year: <input type='text' class='qtr_year'>
                <input type='button' id='submit_qtr_form' onclick='this.form.submit();' value='Update'/>
            </td>
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
          echo $this->Form->end();
            ?>
    </tbody>
</table>
