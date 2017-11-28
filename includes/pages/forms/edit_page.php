<?php
if ($selected = get_page_by_id()) {
    foreach($selected as $selected_page){
    $subject_id = $selected_page['subject_id'];
    $selected_page_menu_name = $selected_page['menu_name'];
    $selected_page_content = $selected_page['content'];
    $selected_page_position = $selected_page['position'];
    $selected_page_visible = $selected_page['visible'];
}
}

?>
<h2>Edit Page <?php echo "{$selected_page_menu_name}"; ?></h2>
<form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'page', $_GET['page'] ?? ''); ?>" method="post">
    <p>Page name: <input id="menu_name" type="text" name="menu_name"
                         value="<?php echo "{$selected_page_menu_name}"; ?>"/></p>
    <p>Content: <textarea id="menu_content" rows="4" cols="50"
                          name="menu_content"><?php echo "{$selected_page_content}"; ?></textarea></p>
    <p>Subject:
        <select name="subject_id">
            <?php
            $subject_set = get_all_subjects();
            foreach ($subject_set as $subject) {
                if ($subject['id'] == $subject_id) {
                    echo "<option value =" . $subject['id'] . " selected>" . $subject['menu_name'] . "</option>";
                } else {
                    echo "<option value =" . $subject['id'] . ">" . $subject['menu_name'] . "</option>";
                }
            }
            ?>
        </select>
    </p>
    <p>Position:
        <select name="position">
            <?php
            $page_set = get_all_pages_for_subjects($subject_id);
            $page_count = count($page_set);
            for ($count = 1; $count <= $page_count; $count++) {
                if ($count == $selected_page_position) {
                    echo "<option value =\"{$count}\" selected>{$count}</option>";
                } else {
                    echo "<option value =\"{$count}\">{$count}</option>";
                }
            }
            ?>
        </select>
    </p>
    <p>Visible:
        <?php
        if ($selected_page_visible == 0) {
            echo "<input type=\"radio\" name=\"visible\" value=\"0\" checked/>No
							&nbsp;
							<input type=\"radio\" name=\"visible\" value=\"1\" />Yes";
        } else {
            echo "<input type=\"radio\" name=\"visible\" value=\"0\" />No
            &nbsp;
							<input type=\"radio\" name=\"visible\" value=\"1\" checked/>Yes";
        }
        ?>
    </p>
    <input type="submit" value="Edit page"/>
</form>
<br/>
<a href="content.php">Cancel</a>
