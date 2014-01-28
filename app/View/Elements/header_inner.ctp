<script type='text/javascript'>
 

    function loadQtrObjs(url1) {

        /* $('#popup_content').html('<img src="<?php echo Router::url('/'); ?>img/loader.gif"/>').css({'text-align':'center'}); */

        url1 = '<?php echo Router::url('/'); ?>' + url1;
        $.ajax({
            url: url1,
            type: "POST",
            success: function(data) {
                $('#popup_content').css({'text-align': 'left'}).html(data);
            }
        });
        return false;
    }

    function loaduserobjs(val) {
        user_id = $('#user_id').val();
        quarter = $('#update_objs li.active a').attr('id');
        quarter = quarter.replace('q', '');
        url = '<?php echo Router::url('/'); ?>priorities/update_objectives/Quarter:' + quarter + '/user_id:' + user_id;
        $.ajax({
            url: url,
            type: "POST",
            success: function(data) {
                $('#popup_content').css({'text-align': 'left'}).html(data);
            }
        });
        return false;

    }

    function get_user(val) {
        if (val.length > 1) {
            $('#small_loader').show();
            $.ajax({
                url: "<?php echo Router::url('/', true); ?>/users/getuserbyname/" + val,
                success: function(data) {
                    $('#small_loader').hide();
                    if (data.length > 10) {
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
        $('.user_' + uid).css({'background': '#ccc'});
        $('.user_' + uid).siblings().css({'background': 'none'});
        $('#user_id').val(uid);
        $('#useroutput').slideUp('fast');
        $('#userinput').val($('.user_' + uid + ' #username').html());
    }

</script>

<?php
if ($this->session->check('Auth.User')) {
    $group = $this->Session->read('Auth.User.Group.id');
	//print_r($group);
    $user = $this->Session->read('Auth.User');
//print_r($user);
    /* pr($user); die; */
    $company_id = $user['company_id'];

    $logged = true;
    if ($group == 1) {
        $admin = true;
    }
    if ($group == 2) {
        $user = true;
    }
    if ($group == 3) {
        $superAdmin = true;
    }
}
?>	

<?php if ($logged) { ?>

    <div class="top_bar">
        <div class="wrapper">
            <ul class="top_social right">
                <li><a href="#"><img src="<?php echo Router::url('/', true); ?>images/t_fb.gif" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo Router::url('/', true); ?>images/t_tw.gif" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo Router::url('/', true); ?>images/t_gp.gif" alt="" /></a></li>
                <li><a href="#"><img src="<?php echo Router::url('/', true); ?>images/t_in.gif" alt="" /></a></li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
        <!-- Header start here -->
        <div class="header">
            <a href="#" class="logo"></a>
            <ul class="logedin_right">
                <li>
                    <?php
                    if ($superAdmin) {
                        echo $this->html->link("Companies", "/companies/superAdminDashboard", array(), null, false);
                    } else {
                        echo $this->html->link("Dashboard", "/dashboard", array(), null, false);
                    }
                    ?>
                    <a href="#" class="lgdin">Administrator</a>
                    <ul>
						<?php if($admin==true) { ?>
						<li><?php echo $this->html->link("Teams", "/teams", array(), null, false); ?> </li>	
						<li><?php echo $this->html->link("Users", "/users/users", array(), null, false); ?></li>
						<li><?php echo $this->html->link("KPIs", "/kpis", array(), null, false); ?> </li>	
						<li><?php echo $this->html->link("Company Profile", "/companies/companyProfile/", array(), null, false); ?> </li>
						<?php } ?>
						
						
                               
                        <?php 
                        if (!$logged) {
                            echo $this->html->link("Login", "/login", array(), null, false);
                        } else {
                            echo '<li>' . $this->html->link("Logout", "/logout", array(), null, false) . '</li>';
                        }
                        ?>

     
                    </ul>
                </li>

            </ul>

            <!-- Main menu -->
            <div class="main_menu">
                <ul>
                    <?php if ($logged == true && !$superAdmin) { ?>
 			<li><?php echo $this->Html->link('My Teams', '/myteams'); ?></li> 
                        <!--<li><?php //echo $this->html->link("Quarterly Objectives", "/objectives", array(), null, false); ?> </li>
                        <li><?php //echo $this->Html->link('Update Objectives', '/priorities/update_objectives', array('title' => 'Update Objectives', 'id' => 'update_objective')); ?></li>------>
			<li><?php echo $this->Html->link('Barriers', '/barriers'); ?></li>	
                        <li><?php echo $this->html->link("Business Plan", "/onePage", array(), null, false); ?></li>
                    <?php } ?>
                    <?php
                    $super_user_id = $this->Session->read('super_user_id');
                    if (!empty($super_user_id)) {
                        echo '<li>';
                        echo $this->Html->link('All Companies', '/companies/logOutAsCompany/' . $super_user_id);
                        echo '</li>';


                    }
                    ?>
                </ul>
            </div>        
        </div>
        <!--	<div class="container">
                <ul class="nav nav-tabs">
                                
                                
                                ?>
                </ul>	
                </div>-->
    <?php } ?>	 

    <!-- sub header ends here-->




