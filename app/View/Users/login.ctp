
<div id='main_login'>
<?php 
	if(!$this->session->check('Auth.User')){
?>
<h1>
 <div class="title">
<span class="font-normal">Login </span> Here 
</div>
</h1>
  <?php 

  echo $this->Form->create('User', array(
											'action' => 'login',
											'inputDefaults' => array(
												'label' => false,
												'div' => false
											)
											));
	?>

  <div class="form-items"> <?php echo	$this->Form->input('email',array('placeholder'=>'Email')); ?> </div>
  <div class="form-items"> <?php echo	$this->Form->input('password',array('type'=>'password','placeholder'=>'Password')); ?> </div>
  <input type="submit" class="submit btn pull-right" value="Go" />
  <span> <a href="<?php	echo $this->html->url('/users/forgot');	?>">Forgot Password?</a></span> <?php echo	$this->Form->end(); ?>
  </form>
  <?php
		} else {
			$username = $this->session->read('Auth.User.username');
			echo " Hello ". $username ."&nbsp;";
			echo $this->html->link("(logout)", "/logout", array(), null, false);
			
		}

	?>
</div>
