<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/pages/header.php");
if (!empty($_POST["menu_name"])) {
    if (array_key_exists('page', $_GET)) {
        update_page($_GET['page']);
    } elseif (array_key_exists('subject', $_GET)) {
        update_subject($_GET['subject']);
    } elseif (array_key_exists('addPage', $_GET)) {
        insert_page();
    } elseif (array_key_exists('addSubject', $_GET)) {
        insert_subject();
    }
}

?>
<table id="structure">
    <tr>
        <td id="navigation">
            <?php include("includes/pages/navigation.php"); ?>
        </td>
        <td id="page">
        <h2>Content Area</h2>
            <?php
            if (array_key_exists('subject', $_GET)) {
                include("includes/pages/forms/edit_subject.php");
            } elseif (array_key_exists('page', $_GET)) {
                include("includes/pages/forms/edit_page.php");
            } elseif (array_key_exists('addPage', $_GET)) {
                include("includes/pages/forms/new_page.php");
            } elseif (array_key_exists('addSubject', $_GET)) {
                include("includes/pages/forms/new_subject.php");
            }
            ?>
        </td>
    </tr>
</table>
<?php require("includes/pages/footer.php"); ?>
