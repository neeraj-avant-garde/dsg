<script type='text/javascript'>
    $(function() {
        config = {
            width: 400,
            toolbar: [
                {name: 'document', items: [ '-', 'NewPage', 'Preview', '-', 'Templates']},
                [ 'Undo', 'Redo'],
                {name: 'basicstyles', items: ['Italic']}
            ]
        };
 
        $('#add_priority').click(function() {
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


        $('#popup_close').click(function() {
            $('#popup_overlay, #popup_box').hide();
        });


        $("#dialog").dialog({
            autoOpen: false,
            modal: true
        });

        $('.delete_priority').click(function(e) {
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


        $('.edit_priority').click(function(e) {
            e.preventDefault();
            $('#popup_overlay, #popup_box').show();
            $('#popup_heading').html($(this).attr('title'));
            $('#popup_content').html('<img src="img/loader.gif"/>').css({'text-align': 'center'});
            url = $(this).attr('href');
            $.ajax({
                url: url,
                type: "POST",
                success: function(data) {
                    $('#popup_content').css({'text-align': 'left'}).html(data);
                    $('.editor').ckeditor(config);
                }
            });

        });


        $('#expand').click(function() {
            $('#objectives').slideDown();
        });


        $('#collapse').click(function() {
            $('#objectives').slideUp();
        });

    });

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

    function setuser(uid) {
        $('.user_' + uid).css({'background': '#ccc'});
        $('.user_' + uid).siblings().css({'background': 'none'});
        $('#user_id').val(uid);
        $('#useroutput').slideUp('fast');
        $('#userinput').val($('.user_' + uid + ' #username').html());
    }


</script>


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
    Are you sure to delete this objective?
</div>
<div class='well well-small'>
    <?php
    if ($this->session->check('Auth.User')) {
        echo $this->Html->link('Add Quarterly Objective', '/priorities/add_priority', array('class' => 'pull-left margin_btn blue_btn', 'id' => 'add_priority', 'title' => 'Add New Quarterly Objective')
        );
    }
    ?>

    <input type='button' value='Expand all' class='margin_btn blue_btn' id='expand'>
    <input type='button' value='Collapse all' class='margin_btn blue_btn' id='collapse'>
    <div class="pagination pull-right" style='margin:0'>
        <ul>
            <li <?php echo ($activeQtr == 1) ? 'class="active"' : ''; ?>><?php echo $this->Html->link('Q1', '/priorities/index/Quarter:1'); ?></li>
            <li <?php echo ($activeQtr == 2) ? 'class="active"' : ''; ?>><?php echo $this->Html->link('Q2', '/priorities/index/Quarter:2'); ?></li>
            <li <?php echo ($activeQtr == 3) ? 'class="active"' : ''; ?>><?php echo $this->Html->link('Q3', '/priorities/index/Quarter:3'); ?></li>
            <li <?php echo ($activeQtr == 4) ? 'class="active"' : ''; ?>><?php echo $this->Html->link('Q4', '/priorities/index/Quarter:4'); ?></li>
        </ul>
    </div>

    <div class='clr'></div>

</div>		

<div id='filters' >
<?php echo $this->Form->create('priorities'); ?>
    <div id='user_filter' class='pull-left'>
        User: <input id="userinput" type="text" onkeyup="getuser(this.value);" name="" />
        <span id="small_loader"><img src="img/loader.gif" width="20px"></span><br>
        <div id="useroutput"></div>
        <input id="user_id" type="hidden" name="user_id">
    </div>

	<?php /*
    <div id='objective_filter' class='pull-left'>
        Objective: <input id="objinput" type="text" onkeyup="getobj(this.value);" name="obj_name" />
        <!--<span id="small_loader"><img src="img/loader.gif" width="20px"></span><br>
        <div id="objoutput"></div>
        <input id="id" type="hidden" name="data[user_id]">-->
    </div>
 */?>
<?php
echo $this->Form->submit(
        'Go', array('class' => 'blue_btn btn btn1', 'title' => 'Go')
);
echo $this->Form->end();
?> 
</form>	

</div>

<div id="gap"></div>
<table class="table table-bordered" id='objectives'>
    <thead>
        <tr>
            <th>Name</th>
            <th>Assigned to</th>
            <th>Complete (# or %)</th>
            <th>Date</th>
            <th></th>
        </tr> 
    </thead>
    <tbody>
<?php
if (!empty($priorities)) {
    foreach ($priorities as $priority) {
//print_r($priority);
        echo '<tr style="margin:5px 0px">';
       echo '<td>' . $priority['Priority']['name'] . '</td>';

        echo '<td>' . $priority['User']['firstname'] . ' ' . $priority['User']['lastname'] . '</td>';

        $completed = $priority['Priority']['completed'];
        $target = $priority['Priority']['target'];

        $width = $completed / $target * 100;
echo "<td style='padding: 0px; background: none repeat scroll 0% 0% rgb(238, 238, 238); border-radius: 0px 6px 6px 0px; box-shadow: -1px 0px 9px 2px #ccc inset;'>";
        echo " <div class='percentbar' style='width:" . $width . "%'>";
        echo '</div>';
        echo '<span class="targetbar">';
        echo $completed . '/' . $target;
        echo '<span>';
        echo '</td>';
        echo '<td>' . date(' M,j, Y', strtotime($priority['Priority']['created'])) . '</td>';

        echo '<td>' . $this->Html->link('Edit', '/priorities/edit_priority/' . $priority['Priority']['id'], array('class' => 'edit_priority', 'title' => 'Edit Objective'));
		
		echo " / ";
		
        echo $this->Html->link('Delete', '/priorities/delete_priority/' . $priority['Priority']['id'], array('class' => 'delete_priority')) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr>';
    echo '<td colspan=5>No results found</td>';
    echo '</tr>';
}
?>
    </tbody>
</table>

