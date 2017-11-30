<?php
if ($selected_subject = get_subject_by_id()){
    $selected_subject_menu_name = $selected_subject['menu_name'];
}
?>
<h2><?php echo("{$selected_subject_menu_name}");?></h2>
                <p id="menu_name" name="menu_name"><?php echo("{$selected_subject_menu_name}"); ?></p>