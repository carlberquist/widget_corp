<?php
if (isset($_GET['subject'])) {
    $subject_query = get_subject('id,position');
    $subject_position = array();
    while ($subject_result = mysqli_fetch_array($subject_query, MYSQLI_ASSOC)) {
        $subject_position[] = $subject_result['position'];
        if ($subject_result['id'] == $_GET['subject']) {
            $selected_subject_query = get_subject('id, menu_name, visible','id = ' . $_GET['subject']);
            while ($selected_subject_result = mysqli_fetch_array($selected_subject_query, MYSQLI_ASSOC)) {
                $selected_subject_menu_name = $selected_subject_result['menu_name'];
                $selected_subject_visible = $selected_subject_result['visible'];
                $selected_subject_position = $subject_result['position'];
            }
        }
    }
}
?>

<h2>Edit Subject <?php echo "{$selected_subject_menu_name}"; ?></h2>
<form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'subject', $_GET['subject'] ?? ''); ?>" method="post">
                <p>Subject name: <input id="menu_name" type="text" name="menu_name" value="<?php echo "{$selected_subject_menu_name}"; ?>" /></p>
                <p>Position:
                    <select name="position">
                        <?php
                        foreach ($subject_position as $position) {
                            if ($position == $selected_subject_position) {
                                echo "<option value =\"{$position}\" selected>{$position}</option>";
                            } else {
                                echo "<option value =\"{$position}\">{$position}</option>";
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                <?php
                if ($selected_subject_visible == 0) {
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
                <input type="submit" value="Edit Subject" />
            </form>
            <br />
            <a href="content.php">Cancel</a>