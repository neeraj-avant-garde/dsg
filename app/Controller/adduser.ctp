<script>
$(function(){
	config = {width:400 };
	$('.editor').ckeditor(config);
	$('.editor').ckeditor(config).val($('#bio').val());
	$( "#hire_date, #birth_date " ).datepicker();

	avt = '<?php echo $this->request->data('User.avtar'); ?>';
	img_src = '<?php echo Router::url('/', true); ?>avtars/'+avt;
	if(avt) {
		$('#InfoBox img').attr("src", img_src);
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
	

	$("#UploadButton").ajaxUpload({
		url : "<?php echo Router::url('/'); ?>users/uploadimage",
		name: "file",
		onComplete: function(result) {
			avt = '<?php echo Router::url('/', true); ?>avtars/'+result;
			$('#avtar').val(result);
			$('#InfoBox img').attr("src", avt);
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
				  var minBound = Math.min(boundx, boundy);
				  jcrop_api = this;
				  $preview.appendTo(jcrop_api.ui.holder);
				  // jcrop_api.animateTo([0, 0, minBound, minBound]);
				});
		}
	});
});


</script>


<h1><div class="title"><span class="font-normal">Add New </span> User</div></h1>
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
		echo $this->Form->create('User', array('action' => 'adduser',
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
			echo $this->Form->input('password', array('placeholder' => 'Password', 'label' => 'Password')).'<br>';
			echo $this->Form->input('title', array('placeholder' => 'title', 'label' => 'Title')).'<br>';
			echo $this->Form->textarea('bio', array('placeholder' => 'Bio', 'class' => 'editor', 'label' => 'Bio')).'<br>';
			echo $this->Form->input('avtar', array('type' => 'hidden', 'id' => 'avtar')).'<br>';
			?>	
			
			<a class="UploadButton" id="UploadButton">UpladFile</a>
			<div id="InfoBox"><img src='' id='cropbox'></div>
			<div id="preview-pane">
				<div class="preview-container">
				  <img src="demo_files/sago.jpg" class="jcrop-preview" alt="" />
				</div>
			</div>
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" value='100'/>
			<input type="hidden" id="h" name="h" value='80'/>
			<input type="hidden" id="image_name" name="image_name" />
		</td>
		<!--// Personal Information -->
		
		<!-- Contact Information -->
		<td class='user_contact_info'>
			<?php
			echo $this->Form->input('phone', array('type' => 'text', 'placeholder' => 'Phone', 'label' => 'Phone')).'<br>';
			//echo $this->Form->input('twitter', array('type' => 'text', 'placeholder' => 'Twitter Url', 'label' => 'Twitter Url')).'<br>';
			//echo $this->Form->input('facebook', array('type' => 'text', 'placeholder' => 'Facebook Url', 'label' => 'Facebook Url')).'<br>';
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
				//$discs = array('DS'=>'DS','DC'=>'DC','DI' => 'DI','CS'=>'CS','IS'=>'IS','CI'=>'CI');
				$discs = array('D'=>'D','DI'=>'DI','DC' => 'Dc','I'=>'I','IS'=>'IS','ID'=>'ID','S'=>'S','SI'=>'SI','SC' => 'SC','C'=>'C','CS'=>'CS','CD'=>'CD');
				echo $this->Form->input('disc', array('type' => 'select','options'=>$discs));
			?>
		</td>
		<!--// DISC Management -->
	</tr>
	
	<tr></tr>
	<tr>
		<td><?php echo $this->Form->input('group_id', array('type' => 'select','options'=>$groups)); ?></td>
		<td>
			<?php
				echo $this->Form->submit('Add User', array('class'=>'btn','add_user_btn'));
				echo $this->Form->end();
			?>
		</td>
	</tr>
	<!-- form end here -->
	
</tbody>
</table>