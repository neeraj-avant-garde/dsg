<?php
if($this->session->check('Auth.User') && $this->session->read('Auth.User.group_id')!=3){	
?>

<script type='text/javascript'>
$(function(){
	$( "#popup_box" ).draggable();
	$('#update_objective').click(function(e) {
	

		$('#popup_overlay, #popup_box').show();
		$('#popup_heading').html($(this).attr('title'));
		$('#popup_content').html('<img src="<?php echo Router::url('/'); ?>img/loader.gif"/>').css({'text-align':'center'});
		url = $(this).attr('href');
		$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
			}
		});
		return false;
	});
	
	$('#popup_close').click(function(){
		$('#popup_overlay, #popup_box').hide();
	});

	
});

function loadQtrObjs(url){

	/* $('#popup_content').html('<img src="<?php echo Router::url('/'); ?>img/loader.gif"/>').css({'text-align':'center'}); */
	
	url = '<?php echo Router::url('/'); ?>'+url;
	$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
			}
	});
	return false;
}

function loaduserobjs(val) {
	user_id = $('#user_id').val();
	quarter = $('#update_objs li.active a').attr('id');
	quarter = quarter.replace('q','');
	url = '<?php echo Router::url('/'); ?>priorities/update_objectives/Quarter:'+quarter+'/user_id:'+user_id;
	$.ajax({
			url: url,
			type: "POST",
			success: function(data){
				$('#popup_content').css({'text-align':'left'}).html(data);
			}
	});
	return false;
	
}
	
function get_user(val) {
	if(val.length > 1) {
		$('#small_loader').show();
		$.ajax({
			  url: "<?php echo Router::url('/', true);?>/users/getuserbyname/"+val,
			  success: function(data){
				$('#small_loader').hide();
				if(data.length > 10) {
					$('#useroutput').slideDown('fast');
					$('#useroutput').html(data);
				} else {
					$("#useroutput").hide();
				}
			  }
		});
	} else {
		$("#useroutput").hide();
	}
}

function setuser(uid) {
		$('.user_'+uid).css({'background':'#ccc'});
		$('.user_'+uid).siblings().css({'background':'none'});
		$('#user_id').val(uid);
		$('#useroutput').slideUp('fast');
		$('#userinput').val($('.user_'+uid+' #username').html());
}	

</script>



<ul class="nav nav-list bs-docs-sidenav affix">
  <li><?php echo $this->Html->link('Update Objectives', '/priorities/update_objectives', array('title'=>'Update Objectives', 'id'=>'update_objective')); ?></li>
  <li><?php echo $this->Html->link('Manage Stucks', '/stucks'); ?></li>
  <li><?php echo $this->Html->link('Daily Huddle', '/teams/dailyHuddle/'); ?></li>
</ul>
<?php } ?>