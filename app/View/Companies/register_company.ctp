<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
<div class="title"><span class="font-normal">Register </span> Your Company</div>
</h1>
	<?php
	echo $this->Form->create('Company', array('action' => 'register_company',
									'inputDefaults' => array(
										'label' => false,
										'div' => false
									)
	));
	echo $this->Form->input('name', array('type' => 'text', 'placeholder' => 'Name', 'label'=>'Name')).'<br>';
	echo $this->Form->input('phone', array('type' => 'text', 'placeholder' => 'Phone', 'label'=>'Phone')).'<br>';
	echo $this->Form->input('website', array('placeholder' => 'website', 'label'=>'Website')).'<br>';
	echo $this->Form->input('email', array('placeholder' => 'email', 'label'=>'Company Email')).'<br>';
	echo $this->Form->input('bus_type', array('placeholder' => 'Bussiness Type', 'label'=>'Bussiness Type')).'<br>';
	echo $this->Form->submit('Register', array('class'=>'btn'));
	echo $this->Form->end();
	?>
