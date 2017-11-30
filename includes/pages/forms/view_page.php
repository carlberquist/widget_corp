<?php
if ($selected = get_page_by_id()) {
    foreach ($selected as $selected_page) {
        $selected_page_menu_name = $selected_page['menu_name'];
        $selected_page_content = $selected_page['content'];
    }
}

?>
<h2><?php echo "{$selected_page_menu_name}"; ?></h2>
    <p id="menu_name" name="menu_name"><?php echo "{$selected_page_menu_name}"; ?></p>
    <p><?php echo "{$selected_page_content}"; ?></p>
