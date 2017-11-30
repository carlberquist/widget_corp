<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/pages/header.php");?>
<table id="structure">
    <tr>
        <td id="navigation">
            <?php include("includes/pages/navigation.php"); ?>
        </td>
        <td id="page">
        <h2>Main Widget page</h2>
            <?php
            if (isset($_GET['subject'])) {
                include("includes/pages/forms/view_subject.php");
            } elseif (isset($_GET['page'])) {
				include("includes/pages/forms/view_page.php");
			}
            ?>
        </td>
    </tr>
</table>
<?php require("includes/pages/footer.php"); ?>