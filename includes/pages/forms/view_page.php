<?php
if ($selected = get_pages('menu_name, content', 'id =' . $_GET['page'])) {
    while ($selected_page = mysqli_fetch_array($selected, MYSQLI_ASSOC)) {
        $selected_page_menu_name = $selected_page['menu_name'];
        $selected_page_content = $selected_page['content'];
    }
}

?>
<h2><?php echo "{$selected_page_menu_name}"; ?></h2>
    <p><?php echo "{$selected_page_content}"; ?></p>
