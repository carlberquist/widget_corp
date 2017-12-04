            <h2>Add Subject</h2>
            <form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'addSubject'); ?>" method="post">
                <p>Subject name: <input id="menu_name" type="text" name="menu_name" value="" /></p>
                <p>Position:
                    <select name="position">
                        <?php
                        $subject_set = get_subject('position');
                        //$subject_count = count($subject_set) +1; //adding a row so we need position +1
                        while ($subject = mysqli_fetch_array($subject_set, MYSQLI_ASSOC)) {
                            $position = $subject['position'];
                            echo "<option value ={$position}>{$position}</option>";
                        }
                        if (isset($position)) {
                            $position1 = $position + 1;
                            echo "<option value ={$position1}>{$position1}</option>";
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
