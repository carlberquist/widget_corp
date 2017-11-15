<?php require_once("../../connection.php"); ?>
<?php require_once("../../functions.php"); ?>
<?php
if (array_key_exists('edit_page', $_GET)) {
    update_page();
    header('widget_corp/content.php');
} elseif (array_key_exists('edit_subject', $_GET)) {
    update_subject($_GET['edit_subject']);
    header('widget_corp/content.php');
} elseif (array_key_exists('new_page', $_GET)) {
    insert_page();
    header('widget_corp/content.php');
} elseif (array_key_exists('new_subject', $_GET)) {
    insert_subject();
    header('widget_corp/content.php');
}
?>
