<script type='text/javascript'>
    $(function() {
        $('#add_team').click(function(e) {
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

        $('.delete_team').click(function(e) {
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



        $('.edit_team').click(function(e) {
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


    function addUserToTeam(id, name) {
        $('.left_' + id).remove();
        clickfun = 'removeUserFromTeam(' + id + ',"' + name + '")';
        content = '<tr class="right_' + id + '">';
        content += "<td><span id='username'  class='pull-left'>" + name + "</span>";
        content += "<span id='add' class='pull-right' onclick='" + clickfun + "'>";
        content += "<input type='button' class='btn' value='remove'/></span></td><tr>";
        $('#right_table tbody tr:last').after(content);

        $('#team_ids').append('<input type="text" id="UserId" value="' + id + '" name="data[User][User][]">');
    }

    function removeUserFromTeam(id, name) {
        $('.right_' + id).remove();
        clickfun = 'addUserToTeam(' + id + ',"' + name + '")';
        content = '<tr class="left_' + id + '">';
        content += "<td><span id='username'  class='pull-left'>" + name + "</span>";
        content += "<span id='add' class='pull-right' onclick='" + clickfun + "'>";
        content += "<input type='button' class='btn' value='add'/></span></td><tr>";
        $('#left_table tbody tr:last').after(content);
    }



</script>


<div id='popup_overlay'></div>
<div id='popup_box'>
    <div id='popup_header'>
        <div id='popup_heading'></div>
        <div id='popup_close'>&#10006;</div>
        <div style='clear:both'></div>
    </div>
    <div id='popup_content'></div>
</div>


<div id="dialog" title="Confirmation Required">
    Are you sure to delete this team?
</div>
<h1 class="list_tit">
<i class="icon"><img src="<?php echo Router::url('/'); ?>images/kp_user.png"/></i>
<div class="title">
<span>Teams</span>
</div>
<div class="right"><?php
     $group = $this->Session->read('Auth.User.Group.id');
     if($group!=2) {
        echo $this->Html->link('Add Team', '/teams/add_team', array('class' => 'btn', 'id' => 'add_team', 'title' => 'Add new Team'));
     }
?></div>
 </h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th></th>
	<th></th>	
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($teams as $team) {
            echo '<tr>';
            echo '<td>' . $team['Team']['name'] . '</td>';
            echo '<td>' . $this->Html->link('Edit', '/teams/edit_team/' . $team['Team']['id'], array('class' => 'edit_team', 'title' => 'Edit Team')).'</td>';
            if($group!=2) {
                echo '<td>'. $this->Html->link('Delete', '/teams/delete_team/' . $team['Team']['id'], array('class' => 'delete_team')).'</td>';
            }
 
            echo '</tr>';
        }
        ?>
<tr>
	<td colspan='7' align='right'>
	<div class="page">
<?php echo $this->Paginator->prev(' Previous', null, null, array('class' => 'enable')); ?>
<?php echo $this->Paginator->numbers(array('first' => 'First page')); ?>
<?php echo $this->Paginator->next('Next ', null, null, array('class' => 'enable')); ?>
</div>	
	</td>

</tr>
    </tbody>
</table>


