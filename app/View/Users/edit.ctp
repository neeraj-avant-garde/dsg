<script>
$(function(){
	config = {width:400 };
	$('.editor').ckeditor(config).val($('#bio').val());
	$( "#hire_date, #birth_date " ).datepicker();

	
	$('#ch_password').click(function(){
		p = $('#password').val();
		cp = $('#confirm_password').val();
		
		
		if(!p) {
			$('.changepassword_error').show().html('Both fileds are required');
			return false;
		}
		if(!cp) {
			$('.changepassword_error').show().html('Both fileds are required');
			return false;
		}	
		if((p.length < 6) || (cp.length < 6)) {
			$('.changepassword_error').show().html('Minimum 6 characters long.');
			return false;
		}	
		if(p!==cp) {
			$('.changepassword_error').show().html('Passwords are not same');
			return false;
		}	
	});
	
	
	/* avt = '<?php echo $this->request->data('User.avtar'); ?>';
	img_src = '<?php echo Router::url('/', true); ?>avtars/'+avt;
	

	if(avt.length > 1) {
		$('#InfoBox img').attr('src', img_src);
		$('.jcrop-preview').attr('src', img_src);
		$('#image_name').val(avt);
			var jcrop_api,
			boundx,
			boundy,

			$preview = $('#preview-pane'),
			$pcnt = $('#preview-pane .preview-container'),
			$pimg = $('#preview-pane .preview-container img'),

			xsize = $pcnt.width(),
			ysize = $pcnt.height();
			
			$('#cropbox').Jcrop({
				aspectRatio: 1,	
				onChange: function(c){
							if (parseInt(c.w) > 0) {
								var rx = xsize / c.w;
								var ry = ysize / c.h;	
								 var bounds = this.getBounds();
							  var boundx = bounds[0];
							  var boundy = bounds[1];
								$pimg.css({
								  width: Math.round(rx * boundx) + 'px',
								  height: Math.round(ry * boundy) + 'px',
								  marginLeft: '-' + Math.round(rx * c.x) + 'px',
								  marginTop: '-' + Math.round(ry * c.y) + 'px'
								});
							  }
						},
				onSelect: function(c){
					$('#x').val(c.x);
					$('#y').val(c.y);
					$('#w').val(c.w);
					$('#h').val(c.h);
				}
				},function(){
				  var bounds = this.getBounds();
				  var boundx = bounds[0];
				  var boundy = bounds[1];
				  jcrop_api = this;
				  $preview.appendTo(jcrop_api.ui.holder);
				});
	} */
	

	$("#UploadButton").ajaxUpload({
		url : "<?php echo Router::url('/'); ?>users/uploadimage",
		name: "file",
		onComplete: function(result) {
			avt = '<?php echo Router::url('/', true); ?>avtars/'+result;
			$('#avtar').val(result);
			$('#InfoBox img').attr("src", avt);
			$('#InfoBox img').attr("width",null);
			$('#InfoBox img').attr("height",null);
			$('.jcrop-preview').attr('src', avt);
			$('#image_name').val(result);
			var jcrop_api,
			boundx,
			boundy,

			$preview = $('#preview-pane'),
			$pcnt = $('#preview-pane .preview-container'),
			$pimg = $('#preview-pane .preview-container img'),

			xsize = $pcnt.width(),
			ysize = $pcnt.height();
			$('#cropbox').Jcrop({
				aspectRatio: 1,	
				onChange: function(c){
							if (parseInt(c.w) > 0) {
							
								 var bounds = this.getBounds();
							  var boundx = bounds[0];
							  var boundy = bounds[1];
								var rx = xsize / c.w;
								var ry = ysize / c.h;	
								$pimg.css({
								  width: Math.round(rx * boundx) + 'px',
								  height: Math.round(ry * boundy) + 'px',
								  marginLeft: '-' + Math.round(rx * c.x) + 'px',
								  marginTop: '-' + Math.round(ry * c.y) + 'px'
								});
							  }
						},
				onSelect: function(c){
					$('#x').val(c.x);
					$('#y').val(c.y);
					$('#w').val(c.w);
					$('#h').val(c.h);
				}
				},function(){
				  var bounds = this.getBounds();
				  var boundx = bounds[0];
				  var boundy = bounds[1];
				  jcrop_api = this;
				  $preview.appendTo(jcrop_api.ui.holder);
				});
		}
	});
});
</script>
<h1><div class="title"><span class="font-normal">Manage </span> Profile</div></h1>

<table class="table table-bordered">
<thead>
	<tr>
		<th>Personal Info</th>
		<th>Contact Info</th>
	</tr>
</thead>
	
<tbody>
	<!-- Form start here -->
	<?php
		echo $this->Form->create('User', array('action' => 'edit',
										'inputDefaults' => array(
											'label' => false,
											'div' => false
										)
		));
		
	?>	
	<tr>
		<!-- Personal Information -->
		<td class='user_personal_info' rowspan=6>
			<?php
			echo $this->Form->input('firstname', array('type' => 'text', 'placeholder' => 'First Name', 'label' => 'First Name')).'<br>';
			echo $this->Form->input('lastname', array('type' => 'text', 'placeholder' => 'Last Name', 'label' => 'Last Name')).'<br>';
			echo $this->Form->input('email', array('placeholder' => 'Email', 'label' => 'Email')).'<br>';
			echo $this->Form->input('title', array('placeholder' => 'title', 'label' => 'Title')).'<br>';
			echo $this->Form->textarea('bio', array('placeholder' => 'Bio', 'class' => 'editor', 'label' => 'Bio')).'<br>';
			// echo $this->Form->input('bio', array('type' => 'hidden', 'id' => 'bio')).'<br>';
			echo $this->Form->input('avtar', array('type' => 'hidden', 'id' => 'avtar')).'<br>';
			?>	
			

			<div id='avtar_image' style='margin-bottom:65px'>
						<div id="preview-pane">
				<div class="preview-container">
				  <img src="demo_files/sago.jpg" class="jcrop-preview" alt="" />
				</div>
			</div>

			<a class="UploadButton" id="UploadButton">UploadFile</a>
			<div id="InfoBox"><img src='<?php echo Router::url('/', true).'avtars/'.$this->request->data('User.avtar'); ?>' id='cropbox'></div>
			
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="image_name" name="image_name" />
			</div>
		</td>
		<!--// Personal Information -->
		
		<!-- Contact Information -->
		<td class='user_contact_info'>
			<?php
			echo $this->Form->input('phone', array('type' => 'text', 'placeholder' => 'Phone', 'label' => 'Phone')).'<br>';
			echo $this->Form->input('twitter', array('type' => 'text', 'placeholder' => 'Twitter Url', 'label' => 'Twitter Url')).'<br>';
			echo $this->Form->input('facebook', array('type' => 'text', 'placeholder' => 'Facebook Url', 'label' => 'Facebook Url')).'<br>';
			echo $this->Form->input('linkedin', array('type' => 'text', 'placeholder' => 'LinkedIn Url', 'label' => 'LinkedIn Url')).'<br>';
			?>	
		</td>
		<!--// Contact Information -->
		
		<tr><th>More info</th></tr>
		<!-- More Information -->
		<td class='user_contact_info'>
			<?php
			echo $this->Form->input('birthdate', array('type' => 'text', 'placeholder' => 'Birthday', 'label' => 'Birthday', 'id'=>'birth_date')).'<br>';
			echo $this->Form->input('hiredate', array('type' => 'text', 'placeholder' => 'Hire Date', 'label' => 'Hire Date', 'id'=>'hire_date')).'<br>';
			echo $this->Form->input('hobbies', array('placeholder' => 'Hobbies', 'label' => 'Hobbies')).'<br>';
			?>	
		</td>
		<!--// More Information -->
		
		<!-- DISC Management -->
		<tr><th>DISC Assesment</th></tr>
		<td> 
			<?php
				$discs = array('DS'=>'DS','DC'=>'DC','DI' => 'DI','CS'=>'CS','IS'=>'IS','CI'=>'CI');
				echo $this->Form->input('disc', array('type' => 'select', 'options'=>$discs, 'selected'=>$this->request->data('User.disc')));
			?>
		</td>
		<!--// DISC Management -->
	</tr>
	
	<tr></tr>
	<tr>
		<td><?php echo $this->Form->input('group_id', array('type' => 'select','options'=>$groups)); ?></td>
		<td>
			<?php
				echo $this->Form->submit('Update User', array('class'=>'btn','id'=>'edit_user_btn'));
				echo $this->Form->end();
			?>
		</td>
	</tr>
	<!-- form end here -->
	
	<!-- DISC & Change password functionality -->
	<tr>

		
		<td colspan=2>
		<!-- Change Password -->
			<div class="changepassword_error message" id="flashMessage" style='display:none'></div>
			<?php 
			echo $this->Form->create('User', array('action'=>'change_password', "autocomplete" =>"off"));
			echo $this->Form->input('password', array('value'=>'', 'id'=>'password'));
			echo $this->Form->input('confirm_password', array('type' => 'password', 'id'=>'confirm_password'));
			echo $this->Form->submit('Submit', array('class'=>'btn', 'id'=>'ch_password'));
			echo $this->Form->end();
			?>
		</td>
		<!--// Change Password -->
	</tr>
	<!--// DISC & Change password functionality -->
	
	
</tbody>
</table>
