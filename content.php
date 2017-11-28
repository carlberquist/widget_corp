<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/pages/header.php");
if (!empty($_POST["menu_name"])) {
    $menu_name = $_POST['menu_name'] ?? "";
    $menu_content = $_POST['menu_content'] ?? "";
    $subject_id = $_POST['subject_id'] ?? "";
    $position = $_POST['position'] ?? "";
    $visible = $_POST['visible'] ?? "";
    if (isset($_GET['page'])) {
        update_page($menu_name, $menu_content, $subject_id, $position, $visible, $_GET['page']);
    } elseif (isset($_GET['subject'])) {
        update_subject($menu_name, $position, $visible, $_GET['subject']);
    } elseif (isset($_GET['addPage'])) {
        insert_page($menu_name, $subject_id, $menu_content, $position, $visible);
    } elseif (isset($_GET['addSubject'])) {
        insert_subject($menu_name, $position, $visible);
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
            if (isset($_GET['subject'])) {
                include("includes/pages/forms/edit_subject.php");
            } elseif (isset($_GET['page'])) {
                include("includes/pages/forms/edit_page.php");
            } elseif (isset($_GET['addPage'])) {
                include("includes/pages/forms/new_page.php");
            } elseif (isset($_GET['addSubject'])) {
                include("includes/pages/forms/new_subject.php");
            }
            ?>
        </td>
    </tr>
</table>
<?php require("includes/pages/footer.php"); ?>
