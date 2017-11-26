<h2>Add Page</h2>
<form action="<?php echo add_or_update_params($_SERVER['PHP_SELF'], 'addPage'); ?>" method="post">
                <p>Page name: <input id="menu_name" type="text" name="menu_name" value="" /></p>
                <p>Content: <textarea id="menu_content" rows="4" cols="50" name="menu_content" value=""></textarea></p>
                <p>Subject:
                    <select name="submit_id" id="submit_id">
                        <?php
                        $subject_set = get_all_subjects();
                        foreach ($subject_set as $subject) {
                            $position = $subject['position'];
                            $menu_name = $subject['menu_name'];
                            $id = $subject['id'];
                            echo "<option value ={$position} data-subject={$id}>{$menu_name}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Position:
                    <select name="position" id="position">
                        <?php 
                        //Javascript on change submit_id, hide positions where subject_id value != subject_id attribute
                        $page_set = get_all_pages();
                        foreach ($page_set as $pages) {
                            if (isset($subject_id) && $subject_id != $pages['subject_id']) {
                                $position1 = $position + 1;
                                echo "<option value={$position1} data-subject={$subject_id}>{$position1}</option>";
                            }
                            $subject_id = $pages['subject_id'];
                            $position = $pages['position'];
                            echo "<option value={$position} data-subject={$subject_id}>{$position}</option>";
                        }
                        if (isset($position1)) {
                            $position = $position + 1;
                            echo "<option value={$position} data-subject={$subject_id}>{$position}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                <?php
                echo "<input type=\"radio\" name=\"visible\" value=\"0\" />No
							&nbsp;
							<input type=\"radio\" name=\"visible\" value=\"1\" />Yes";
                ?>
                </p>
                <input type="submit" value="Add page" />
            </form>
            <br />
            <a href="content.php">Cancel</a>
            <script type='text/javascript'>
                    function dropdown(){
                        var submit_id = this.options[this.selectedIndex].dataset.subject; //get data value of currently selected option
                        var page_options = document.getElementById('position');
                        for (i = 0; i < page_options.options.length; i++) {
                            if (submit_id == page_options.options[i].dataset.subject){
                                page_options.options[i].style.display = "block"; //hide keeps original position / display removes other elements from the DOM.
                            }
                            else{
                                page_options.options[i].style.display = "none";
                            }
                        }
                    }
                    document.addEventListener('DOMContentLoaded',function() {
                        var submit_id = document.getElementById('submit_id');
                        dropdown.call(submit_id); //first option this arg, 2nd function args
                        submit_id.addEventListener("change", dropdown, false);
                        // document.querySelector('select[name="submit_id"]').onchange=dropdown; //document.querySelector gets first element that matches.
                    } ,false); //false enables event to bubble
                        </script>