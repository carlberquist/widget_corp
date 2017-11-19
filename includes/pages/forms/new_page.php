<h2>Add Page</h2>
<form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'addPage');?>" method="post">
                <p>Page name: <input id="menu_name" type="text" name="menu_name" value="" /></p>
                <p>Content: <textarea id="menu_content" rows="4" cols="50" name="menu_content" value=""></textarea></p>
                <p>Subject:
                    <select name="submit_id">
                        <?php
                        $subject_set = get_all_subjects();   
                        while ($subject = mysqli_fetch_array($subject_set)){
                                echo "<option value =\"" . $subject['id'] . "\" selected>" . $subject['menu_name'] . "</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Position:
                    <select name="position">
                        <?php //Fix page position to change to get new subject positions when subject is changed  
                        $page_set = get_all_pages();
                        $page_count = mysqli_num_rows($page_set) +1; //adding a row so we need position +1
                        for ($count = 1; $count <= $page_count; $count++) {
                                echo "<option value =\"{$count}\" selected>{$count}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                <?php
                    echo "<input type=\"radio\" name=\"visible\" value=\"0\" checked/>No
							&nbsp;
							<input type=\"radio\" name=\"visible\" value=\"1\" />Yes";
                        ?>
                </p>
                <input type="submit" value="Edit page" />
            </form>
            <br />
            <a href="content.php">Cancel</a>