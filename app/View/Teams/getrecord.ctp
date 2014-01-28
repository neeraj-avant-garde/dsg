<script type="text/javascript">
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
</script>
<?php

echo '<table class="table table-bordered">';
$group = $this->Session->read('Auth.User.Group.id');
$userId = $this->Session->read('Auth.User.id');
echo '<thead>';
echo '<tr>';
echo '<th>Objective</th>';
echo '<th>Assigned to</th>';
echo '<th>Complete %</th>';
echo '<th>Updated</th>';
echo '<th></th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($ro as $row) {
    $completed = $row['priorities']['completed'];
    $target = $row['priorities']['target'];
    $width = $completed / $target * 100;

    echo '<tr><td>' . $row['priorities']['name'] . '</td>';
    echo '<td>' . $row['users']['firstname'] . '</td>';
    //echo  '<td>'.$completed . '/' . $target.'</td>';
    echo "<td style='padding: 0px; background: none repeat scroll 0% 0% rgb(238, 238, 238); border-radius: 0px 6px 6px 0px; box-shadow: -1px 0px 9px 2px #ccc inset; overflow:hidden'>";
    echo " <div class='percentbar' style='width:" . $width . "%'>";
    echo '</div>';
    echo '<span class="targetbar">';
    echo $completed . '/' . $target;
    echo '<span>';
    echo '</td>';
    echo '<td>' . date('M,j,Y', strtotime($row['priorities']['modified'])) . '</td>';

    if ($group == 2 && $row['priorities']['user_id'] != $userId) {
        echo '<td></td>';
    } else {
        echo '<td>' ;
		
		echo $this->Html->link('View Log', '/teams/viewobjectivelog/' . $row['priorities']['id'], array('class' => 'edit_team edit_priority', 'title' => 'Objective Log')) . ' / ';
		
		
		echo $this->Html->link('Edit', '/priorities/edit_priority/' . $row['priorities']['id'], array('class' => 'edit_priority', 'title' => 'Edit Objective'));
        echo " / ";

        echo $this->Html->link('Delete', '/priorities/delete_priority/' . $row['priorities']['id'], array('class' => 'delete_priority')) . '</td>';
    }
}
echo '<tbody>';
echo '</table>';
die();
?>

