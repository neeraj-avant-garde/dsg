 <?php
	if($this->session->check('Auth.User')){	
		$group = $this->Session->read('Auth.User.Group.id');
		$user = $this->Session->read('Auth.User');
		$logged = true;
		if($group==1) {	$admin = true; } 
		if($group==2) {	$user = true; } 
	}
?>	

<!-- top header starts here-->
<div class="top_header">
        <div class="wrapper">
			<ul class='main-nav'>
				<li><?php echo $this->Html->link('Register your company Now', '/companies/register_company/'); ?></li>	
			</ul>	
             <div class="social_icon">	
                     <a href="#"><img src="<?php echo Router::url('/', true); ?>images/fb.png" alt="facebook" /></a>
                     <a href="#"><img src="<?php echo Router::url('/', true); ?>images/twitter.png" alt="twitter" /></a>
                     <a href="#"><img src="<?php echo Router::url('/', true); ?>images/google.png" alt="google" /></a>
                     <a href="#"><img src="<?php echo Router::url('/', true); ?>images/in.png" alt="linkedin" /></a>
             </div>
        </div>
</div>
<!-- top header ends here-->

<!-- sub header starts here-->
<div class="sub_header">
            <div class="wrapper">
                        <a class="logo" href="<?php echo Router::url('/', true); ?>"><img src="<?php echo Router::url('/', true); ?>images/logo.jpg" alt="logo" /></a>

						<?php 
							if(!$logged) {
								echo $this->Form->create('User', array('action' => 'login', 'id' => 'login_form', 
																'inputDefaults' => array(
																	'label' => false,
																	'div' => false
																)
								));
								
								echo $this->Form->input('email', array('placeholder' => 'Email address'));
								echo $this->Form->input('password', array('placeholder' => 'Password'));
								
						?>
							<button class="submit">Go</button>
                            
                             <input type="checkbox" />
                             <label>Keep me logged in</label>
                             <label class="password">Forgot your passowrd?</label>
							 
						<?php 
							echo $this->Form->end();

							} else {
						?>	
							<ul class="main-menu" id='login_form'>
									<li> 
									<?php 
									if(!$logged){ echo $this->html->link("Login", "/login", array(), null, false); } 
									else {	echo $this->html->link("Logout", "/logout", array(), null, false);	}
									?></li>
									<?php if($logged==true) { ?>
										<?php  /* echo $this->html->link("Quarterly Objectives", "/priorities", array(), null, false); ?> </li>				
										<?php if($admin==true) { ?>
											<li><?php echo $this->html->link("Users", "/users/users", array(), null, false); ?></li>
											<li><?php echo $this->html->link("KPIs", "/objectives", array(), null, false);  ?> </li>		
											<li><?php echo $this->html->link("Teams", "/teams", array(), null, false);  ?> </li>		
											<li><?php echo $this->html->link("Quarters", "/quarters", array(), null, false);  ?> </li>		
										<?php } */ ?>
										
										<li><?php echo $this->html->link("Dashboard", "/dashboard", array(), null, false); ?></li>
									<?php } ?>
							</ul>		
						<?php	}			?>	 
            </div>
</div>
<!-- sub header ends here-->

		


	