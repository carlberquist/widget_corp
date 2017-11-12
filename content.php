<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/pages/header.php"); ?>
<table id="structure">
    <tr>
        <td id="navigation">
            <?php  include("includes/pages/navigation.php"); ?>
        </td>
        <td id="page">
            <h2>Content Area</h2>
            <h2><?php $subject_menu = get_subject_by_id();
            echo array_exists('menu_name', $subject_menu, ""); ?></h2>          
            <h3><?php $page_menu = get_page_by_id();
            echo array_exists('menu_name', $page_menu, ""); ?></h3>
            <div class="page-content">
                <p><?php $page_content = get_page_by_id();
                echo array_exists('content', $page_content, ""); ?></p>
            </div>
        </td>
    </tr>
</table>
<?php require("includes/pages/footer.php"); ?>
