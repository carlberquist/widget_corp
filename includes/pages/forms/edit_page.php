<?php
if ($pages = get_pages('id, position', $_GET['page'])) {
    $position = array();
    while ($page = mysqli_fetch_array($pages, MYSQLI_ASSOC)) {
        $position[] = $page['position'];
        if ($page['id'] == $_GET['page']) {
            $selected = get_pages('subject_id, menu_name, content, visible', 'id = ' . $_GET['page']);
            while ($selected_page = mysqli_fetch_array($selected, MYSQLI_ASSOC)) {
                $subject_id = $selected_page['subject_id'];
                $selected_page_menu_name = $selected_page['menu_name'];
                $selected_page_content = $selected_page['content'];
                $selected_page_position = $page['position'];
                $selected_page_visible = $selected_page['visible'];
            }
        }
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
            $subject_set = get_subject('id ,menu_name');
            while ($subject = mysqli_fetch_array($subject_set, MYSQLI_ASSOC)) {
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
            foreach ($position as $pos) {
                if ($pos == $selected_page_position) {
                    echo "<option value =\"{$pos}\" selected>{$pos}</option>";
                } else {
                    echo "<option value =\"{$pos}\">{$pos}</option>";
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
