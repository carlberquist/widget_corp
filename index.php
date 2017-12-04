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
            //TODO Protect content.php and edit pages
            //TODO add parser for different Serized elements
            //TODO Json encode content with field type, bootstrap width, id and value 
            //TODO JSON decode fields on to page <div data-side="front" data-params="php echo htmlspecialchars(json_encode($dataParams), ENT_QUOTES, 'UTF-8');">  
            //TODO add MySQL counts and clean up functions
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