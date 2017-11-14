<h2>Add Page</h2>
<form action="<?php echo add_or_update_params('includes/pages/forms/process_form.php', 'new_page');?>" method="post">
                <p>Subject name: <input id="menu_name" type="text" name="menu_name" value="" /></p>
                <p>Content: <textarea id="menu_content" rows="4" cols="50" name="menu_content" value=""></textarea></p>
                <p>Position:
                    <select name="position">
                        <?php
                        $subject_set = get_all_subjects();
                        $subject_count = mysqli_num_rows($subject_set) +1; //adding a row so we need position +1
                        for ($count = 0; $count <= $subject_count; $count++) {
                            if ($count == 0) {
                                echo "<option value = \"\" disabled selected>Select</option>";
                            } else {
                                echo "<option value ={$count}>{$count}</option>";
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0" />No
                            &nbsp;
                            <input type="radio" name="visible" value="1" />Yes
                </p>
                <input type="submit" value="Edit Subject" />
            </form>
            <br />
            <a href="content.php">Cancel</a>
