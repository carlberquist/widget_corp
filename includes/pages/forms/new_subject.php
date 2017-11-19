            <h2>Add Subject</h2>
            <form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'addSubject');?>" method="post">
                <p>Subject name: <input id="menu_name" type="text" name="menu_name" value="" /></p>
                <p>Position:
                    <select name="position">
                        <?php
                        $subject_set = get_all_subjects();
                        //$subject_count = count($subject_set) +1; //adding a row so we need position +1
                        foreach ($subject_set as $subject) {
                           $position = $subject['position'];
                            $id = $subject['id'];
                                echo "<option value ={$position} data-subject={$id}>{$position}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0" />No
                    &nbsp;
                    <input type="radio" name="visible" value="1" />Yes
                </p>
                <input type="submit" value="Add Subject" />
            </form>
            <br />
            <a href="content.php">Cancel</a>
