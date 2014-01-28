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
			
/* 	1st Jan to 31 Mar = Jan, 01, 2013
	1st April to 30 june
	1st july to 30 sep
	1st oct to 31 dec */
		$('.rangetype').change(function(){
			type = $(this).val();
			yr = 2013;
			if(type==1){
				$('#Quarter0StartDate').val('Jan, 01, '+yr);
				$('#Quarter0EndDate').val('Mar, 31, '+yr);
				$('#Quarter1StartDate').val('Apr, 01, '+yr);
				$('#Quarter1EndDate').val('Jun, 30, '+yr);
				$('#Quarter2StartDate').val('Jul, 01, '+yr);
				$('#Quarter2EndDate').val('Sep, 30, '+yr);
				$('#Quarter3StartDate').val('Oct, 01, '+yr);
				$('#Quarter3EndDate').val('Dec, 31, '+yr);
			} else {
				$('#Quarter0StartDate').val('Apr, 01, '+yr);
				$('#Quarter0EndDate').val('Jun, 30, '+yr);
				$('#Quarter1StartDate').val('Jul, 01, '+yr);
				$('#Quarter1EndDate').val('Sep, 30, '+yr);
				$('#Quarter2StartDate').val('Oct, 01, '+yr);
				$('#Quarter2EndDate').val('Dec, 31, '+yr);
				$('#Quarter3StartDate').val('Jan, 01, '+yr);
				$('#Quarter3EndDate').val('Mar, 31, '+yr);
			}
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
$rangeType = $company['qtrrangetype'];
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
echo $this->Form->create('Company', array('action' => 'updateCompanyQtrType','name'=>'', 'inputDefaults' => array(
        'label' => false,
        'div' => false)));
$yearOptions = array(1 => 'Jan1 - Dec31', 'Apr1- Mar31');
?>																
<table class="table table-bordered">

    <thead>
        <tr>
            <td colspan='3'>
                <?php 
					echo $this->Form->input('qtrrangetype',	
												array(
													'type', 'select',
													'options'=>$yearOptions,
													'label'=>'Financial year range', 
													'default' => $rangeType, 
													'class'=>'rangetype'
												) 
											);
					 echo $this->Form->hidden('id', array('value' => $company['id']));						
				?>
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
