<?php
$sel_d = "$('#slectday').val()";
?>

<script>
    function loadInfo(id) {
        $('#userinfo_' + id).slideDown();
        $('#btn_' + id).attr('onclick', 'unloadInfo(' + id + ')').html('&#8212;');
    }
    function unloadInfo(id) {
        $('#userinfo_' + id).slideUp();
        $('#btn_' + id).attr('onclick', 'loadInfo(' + id + ')').html('&#10010;');
    }

    function getPriorities(ObjTeam){
        var id = $(ObjTeam).val();
        quarterid = $("#qtrid").val();
        var dataString = 'id=' + id + '&quarterid=' + quarterid;

        url = '<?php echo Router::url("/"); ?>teams/getrecord';
		if(id!=0) {
			$('#small_loader').show();
			$.ajax({
				type: "POST",
				url: url,
				data: dataString,
				success: function(response){
					$('#small_loader').hide();
					$(".city").html(response);
				}
			});
			return false;
		}        
    }

    $(function() {
        config = {
            toolbar: [
                {name: 'document', items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates']},
                ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'],
                {name: 'basicstyles', items: ['Bold', 'Italic']}
            ]
        };
        $('.editor').ckeditor(config);

        $('#dailypriority').each(function() {
            $(this).click(function() {
                $(this).next('#dailypriority_editform').show();
                $(this).hide();
            });
        });


        $('#expandall').click(function() {
            $('.userinfo').slideDown();
            $('.btn_expand').html('&#8212;');
        });

        $('#closeall').click(function() {
            $('.userinfo').slideUp();
            $('.btn_expand').html('&#10010;');
        });


        $('.team_name li a').each(function() {
            $(this).click(function(e) {
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
                imgurl = '<?php echo Router::url('/'); ?>img/loader.gif';
                $('#all_users').html('<div style="text-align:center"><img src="' + imgurl + '"></div>');
                e.preventDefault();
                val = $('#slectday').val();
                url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {sel_date: val},
                    success: function(data) {
                        content = $(data).find('#all_users').html();
                        $('#all_users').html(content);
                        $('.editor').ckeditor(config);
                    }
                });
            });
        });

        $('#slectday').datepicker({dateFormat: 'yy-mm-dd'});


 $('.update_objective').click(function() {
            $('#popup_overlay, #popup_box').show();
            $('#popup_heading').html($(this).attr('title'));
            $('#popup_content').html('<img src="<?php echo Router::url('/'); ?>img/loader.gif"/>').css({'text-align': 'center'});
            url = $(this).attr('href');
            $.ajax({
                url: url,
                type: "POST",
                success: function(data) {
                    $('#popup_content').css({'text-align': 'left'}).html(data);
                }
            });
            return false;

        });


        $('.add_stuck').on('click', function(e) {
            e.preventDefault();
            $('#popup_overlay, #popup_box').show();
            $('#popup_heading').html($(this).attr('title'));
            imgurl = '<?php echo Router::url('/'); ?>img/loader.gif';
            $('#popup_content').html('<img src="' + imgurl + '"> ').css({'text-align': 'center'});
            url = $(this).attr('href');
            $.ajax({url: url,
                type: "POST",
                success: function(data) {
                    $('#popup_content').css({'text-align': 'left'}).html(data);
                    $(".multiselect").multiselect();
                }
            });
        });

        $("#dialog").dialog({
            autoOpen: false,
            modal: true
        });

        $('.delete_stuck').click(function(e) {
            e.preventDefault();
            var targetUrl = $(this).attr("href");
            $("#dialog").dialog({
                buttons: {
                    "Confirm": function() {
                        window.location.href = targetUrl;
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });

            $("#dialog").dialog("open");
        });

        $('#popup_close').click(function() {
            $('#popup_overlay, #popup_box').hide();
        });



        $('.edit_stuck').click(function(e) {
            e.preventDefault();
            $('#popup_overlay, #popup_box').show();
            $('#popup_heading').html($(this).attr('title'));
            imgurl = '<?php echo Router::url('/'); ?>img/loader.gif';
            $('#popup_content').html('<img src="' + imgurl + '">').css({'text-align': 'center'});
            url = $(this).attr('href');
            $.ajax({
                url: url,
                type: "POST",
                success: function(data) {
                    $('#popup_content').css({'text-align': 'left'}).html(data);
                    $(".multiselect").multiselect();
                }
            });

        });

        $(".te_priority").change(function() {
            getPriorities(this)
        });
		
		$('.pagination ul li').click(function(){
			$('.pagination ul li').removeClass('active');
			$(this).addClass('active');
		});
		
		  $('#add_priority').click(function() {
                    
                    //alert("hi");
                    //return false;
            $('#popup_overlay, #popup_box').show();
            $('#popup_heading').html($(this).attr('title'));
            $('#popup_content').html('<img src="<?php echo IMAGES_URL; ?>/loader.gif" alt="loading.."/> ').css({'text-align': 'center'});
            url = $(this).attr('href');
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'text',
                success: function(data) {
                    $('#popup_content').css({'text-align': 'left'}).html(data);
                    $('.editor').ckeditor(config);
                }
            });

            return false;
        });
		
        setQtr(<?php echo $activeQuarter ?>)
        getPriorities($('#TeamField'))		
		
    });
    
    

    function showDiv(id) {
        $('#dailypriority_editform_' + id).show();
        $('#dailypriority_' + id).hide();
    }

    function hideDiv(id) {
        $('#dailypriority_editform_' + id).hide();
        $('#dailypriority_' + id).show();
    }


    function loadAgain(val) {
        url = $('.team_name li.active a').attr('href');
        imgurl = '<?php echo Router::url('/'); ?>img/loader.gif';
        $('#all_users').html('<div style="text-align:center"><img src="' + imgurl + '"></div>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {sel_date: val},
            success: function(data) {
                content = $(data).find('#all_users').html();
                $('#all_users').html(content);
                $('.editor').ckeditor(config);
            }
        });
    }

    function incrementDate() {
        date = $('#slectday').val();
        n_date = incr_date(date);
        $('#slectday').val(n_date);
        loadAgain(n_date);
    }


    function minusDate() {
        date = $('#slectday').val();
        n_date = dcre_date(date);
        $('#slectday').val(n_date);
        loadAgain(n_date);
    }

    function incr_date(date_str) {
        var parts = date_str.split("-");
        var dt = new Date(
                parseInt(parts[0], 10), // year
                parseInt(parts[1], 10) - 1, // month (starts with 0)
                parseInt(parts[2], 10)       // date
                );
        dt.setDate(dt.getDate() + 1);
        parts[0] = "" + dt.getFullYear();
        parts[1] = "" + (dt.getMonth() + 1);
        if (parts[1].length < 2) {
            parts[1] = "0" + parts[1];
        }
        parts[2] = "" + dt.getDate();
        if (parts[2].length < 2) {
            parts[2] = "0" + parts[2];
        }
        return parts.join("-");
    }
    function dcre_date(date_str) {
        var parts = date_str.split("-");
        var dt = new Date(
                parseInt(parts[0], 10), // year
                parseInt(parts[1], 10) - 1, // month (starts with 0)
                parseInt(parts[2], 10)       // date
                );
        dt.setDate(dt.getDate() - 1);
        parts[0] = "" + dt.getFullYear();
        parts[1] = "" + (dt.getMonth() + 1);
        if (parts[1].length < 2) {
            parts[1] = "0" + parts[1];
        }
        parts[2] = "" + dt.getDate();
        if (parts[2].length < 2) {
            parts[2] = "0" + parts[2];
        }
        return parts.join("-");
    }
    function getuser(val) {
        if (val.length > 0) {
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

    function getUserByNameAndTeamId(name) {
        teamId = $('#TeamField').val()
        if (name.length > 0) {
            $('#small_loader').show();
            $.ajax({
                url: "<?php echo Router::url('/', true); ?>/users/getUserByNameAndTeamId?teamId=" + teamId +"&name="+ name,
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


    function setQtr(val) {
        $('#qtrid').val(val);
    

    }
</script>

<div class='container'>
    <h2>My Teams Objectives</h2>
    <div id='popup_overlay'></div>
    <div id='popup_box'>
        <div id='popup_header'>
            <div id='popup_heading'></div>
            <div id='popup_close'><img src="<?php echo Router::url('/'); ?>images/cross.png"/></div>
            <div style='clear:both'></div>
        </div>
        <div id='popup_content'></div>
    </div>

    <div id="dialog" title="Confirmation Required">
        Are you sure to delete this stuck?
    </div>

    <div class='well well-small'>
        <div class="pagination pull-left">
            <ul>
                <li <?php echo ($activeQuarter == 1) ? 'class="active"' : ''; ?> ><a href="javascript:void(0);" onclick="setQtr(<?php echo $active[0]['quarters']['id'];?>);" >Q1</a></li>
                <li <?php echo ($activeQuarter == 2) ? 'class="active"' : ''; ?> ><a href="javascript:void(0);" onclick="setQtr(<?php echo $active[1]['quarters']['id'];?>);" >Q2</a></li>
                <li <?php echo ($activeQuarter == 3) ? 'class="active"' : ''; ?> ><a href="javascript:void(0);" onclick="setQtr(<?php echo $active[2]['quarters']['id'];?>);" >Q3</a></li>
                <li <?php echo ($activeQuarter == 4) ? 'class="active"' : ''; ?> ><a href="javascript:void(0);" onclick="setQtr(<?php echo $active[3]['quarters']['id'];?>);" >Q4</a></li>
 
<!--<input type="hidden" id="quarter_id" name="quarter_id" value="<?php $active ?>" />
<input type="hidden" id="select_field" name="select_field" value="<?php $dailyHuddle ?>" />
-->
            </ul>
            <ul>
				<li>
					 <?php
					if ($this->session->check('Auth.User')) {                                          
						echo $this->Html->link('Add Quarterly Objective', '/priorities/add_priority', array('class' => 'pull-left margin_btn blue_btn', 'id' => 'add_priority', 'title' => 'Add New Quarterly Objective')
						);
					}
					?>
					<?php echo $this->Html->link('Update Objectives', '/priorities/update_objectives', array('title' => 'Update Objectives', 'class' => 'update_objective pull-left margin_btn blue_btn')); ?>

				</li>
            </ul>
        </div>
        <div class="pull-left clear" >
            <?php
            //echo $this->Form->input('team_id',array('type'=>'select', 'options'=>$teams );
			echo $this->Form->create('Team', array('action' => 'getrecord',
				'inputDefaults' => array(
					'label' => false,
					'div' => false
				), 'class' => 'ajx_form'
			));
            echo $this->Form->input('field', array('type' => 'select', 'class' => 'te_priority', 'label' => false,
                'options' => $dailyHuddle, 'default' => 'select'));
            ?>
			<span id="small_loader" style="display: none;">
				<img width="20px" src="img/loader.gif">
			</span>
            <input type='hidden' name='qtrid' id='qtrid' value="<?php echo $quarterid; ?>"/>
        </div>
        <div class="clear"></div>
        <div class="city">
        </div>
    </div>
</div>






