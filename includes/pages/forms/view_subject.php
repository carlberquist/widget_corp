<?php
if (isset($_GET['subject'])) {
    $selected_subject_query = get_subject('menu_name', 'id = ' . $_GET['subject']);
    while ($selected_subject_result = mysqli_fetch_array($selected_subject_query, MYSQLI_ASSOC)) {
        $selected_subject_menu_name = $selected_subject_result['menu_name'];
    }
}
?>
<h2><?php echo ("{$selected_subject_menu_name}"); ?></h2>
                <p id="menu_name" name="menu_name"><?php echo ("{$selected_subject_menu_name}"); ?></p>