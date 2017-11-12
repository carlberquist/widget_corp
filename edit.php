<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/pages/header.php");
?>
<table id="structure">
    <tr>
        <td id="navigation">
            <?php  include("includes/pages/navigation.php"); ?>
        </td>
        <td id="page">
            <?php
            if (array_exists('subject', $_GET, false)) {
                include("includes/pages/forms/edit_subject.php");
            } elseif (array_exists('page', $_GET, false)) {
                include("includes/pages/forms/edit_page.php");
            }
            ?>
        </td>
    </tr>
</table>
<?php require("includes/pages/footer.php"); ?>
