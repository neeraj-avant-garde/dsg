<h1 class="list_tit"><i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i><div class="title">
<span class="font-normal">Edit Company </span>   
</div></h1>
<table>
<?php
echo $this->Form->create('Company', array('action' => 'edit_company',
								'inputDefaults' => array(
									'label' => false,
									'div' => false
								)
));
echo "<tr><th style='border:none;'>Name</th><td style='border:none;'>".$this->Form->input('name', array('type' => 'text', 'placeholder' => 'Name')).'</td></tr>';
echo "<tr><th style='border:none;'>Phone</th><td style='border:none;'>".$this->Form->input('phone', array('type' => 'text', 'placeholder' => 'Phone')).'</td></tr>';
echo "<tr><th style='border:none;'>Website</th><td style='border:none;'>".$this->Form->input('website', array('placeholder' => 'website')).'</td></tr>';
echo "<tr><th style='border:none;'>Email of your company</th><td style='border:none;'>".$this->Form->input('email', array('placeholder' => 'email')).'</td></tr>';
echo "<tr><th style='border:none;'>Bussiness Type</th><td style='border:none;'>".$this->Form->input('bus_type', array('placeholder' => 'Bussiness Type')).'</td></tr>';
echo "<tr><td colspan='2' style='border:none;'>".$this->Form->submit('Update Company', array('class'=>'btn'))."</td></tr>";
echo $this->Form->end();
?>	
</table>
