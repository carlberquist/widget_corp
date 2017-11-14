<?php require_once("../../connection.php"); ?>
<?php require_once("../../functions.php"); ?>
<?php
if (array_key_exists('edit_page', $_GET)) {
    update_page();
} elseif (array_key_exists('edit_subject', $_GET)) {
    update_subject();
} elseif (array_key_exists('new_page', $_GET)) {
    insert_page();
} elseif (array_key_exists('new_subject', $_GET)) {
    insert_subject();
}
?>
