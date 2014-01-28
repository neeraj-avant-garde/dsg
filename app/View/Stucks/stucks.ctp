<script type='text/javascript'>
    $(function() {
        $('#add_stuck').click(function(e) {
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
            $('#popup_content').html('<img src="img/loader.gif"/>').css({'text-align': 'center'});
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
    Are you sure to delete this stuck?
</div>


<h2><div class="title"><span class="font-normal">Manage</span> Barriers</div> </h2>
<?php
echo $this->Html->link('Add Barrier', '/stucks/add_stuck', array('class' => 'btn load_ajax', 'id' => 'add_stuck', 'title' => 'Add Barrier')
);
?>
<!-- Things I am holding up -->
<table class="table table-bordered" id='manage_stucks'>
    <thead>

        <tr><th><h4>Things I am holding up</h4></th></tr>
         

<tr>
    <th>Barrier Description</th>
    <!--<th>Person Barrier</th>-->
    <th>Barrier Assign by</th>
    <th>Barrier Since</th>
</tr>
</thead>
<tbody>
    <?php
    foreach ($stucks_holds as $stuck) {
        $from = $userModel->read(array('firstname', 'lastname'), $stuck['Stuck']['user_id']);
        $from = $from['User']['firstname'] . ' ' . $from['User']['lastname'];
        echo '<tr>';
        echo '<td>' . $stuck['Stuck']['notes'] . '</td>';
        echo '<td>' . $from . '</td>';
        echo '<td>' . date('Y-m-d', strtotime($stuck['Stuck']['created'])) . '</td>';
        echo '</tr>';
    }
    ?>

</tbody>
</table>
<!--// Things I am holding up -->	

<!-- Things I am stuck on -->																	
<table class="table table-bordered" id='manage_stucks'>
    <thead>

        <!--<tr><th><h4>Things I am stuck on</h4></th></tr>-->
        <tr><th><h4>Things i need help with</h4></th></tr>

<tr>
    <th>Barrier Description</th>
    <th>Need Help From</th>
    <th>Barrier Since</th>
    <th></th>
    <th></th>
</tr>
</thead>
<tbody>
    <?php
    foreach ($stucks_on as $stuck) {
        $from = $userModel->read(array('firstname', 'lastname'), $stuck['Stuck']['from']);
        $from = $from['User']['firstname'] . ' ' . $from['User']['lastname'];
        echo '<tr>';
        echo '<td>' . $stuck['Stuck']['notes'] . '</td>';
        echo '<td>' . $from . '</td>';
        echo '<td>' . date('Y-m-d', strtotime($stuck['Stuck']['created'])) . '</td>';
        echo '<td>' . $this->Html->link('Edit', '/stucks/edit_stuck/' . $stuck['Stuck']['id'], array('class' => 'edit_stuck', 'title' => 'Edit Barrier')) . '</td>';
        echo '<td>' . $this->Html->link('Delete', '/stucks/delete_stuck/' . $stuck['Stuck']['id'], array('class' => 'delete_stuck')) . '</td>';
        echo '</tr>';
    }
    ?>	
</tbody>
</table>

<!--// Things I am stuck on -->


