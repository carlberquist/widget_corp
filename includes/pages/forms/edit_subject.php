<?php
if ($selected_subject = get_subject_by_id()){
    $selected_subject_menu_name = $selected_subject['menu_name'];
    $selected_subject_visible = $selected_subject['visible'];
    $selected_subject_position = $selected_subject['position'];
}
?>

<h2>Edit Subject <?php echo "{$selected_subject_menu_name}"; ?></h2>
<form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'subject', array_exists('subject', $_GET));?>" method="post">
                <p>Subject name: <input id="menu_name" type="text" name="menu_name" value="<?php echo "{$selected_subject_menu_name}"; ?>" /></p>
                <p>Position:
                    <select name="position">
                        <?php
                        $subject_set = get_all_subjects();
                        $subject_count = mysqli_num_rows($subject_set); //adding a row so we need position +1
                        for ($count = 1; $count <= $subject_count; $count++) {
                            if ($count == $selected_subject_position) {
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
