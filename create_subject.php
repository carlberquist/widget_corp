<?php
require_once("includes/connection.php");
require_once("includes/functions.php");

$menu_name = array_exists($_POST,'menu_name', NULL);
$position = array_exists($_POST,'position', NULL);
$visible = array_exists($_POST,'visible', NULL);

$required_fields = array('menu_name', 'position', 'visible');
check_required_fields($required_fields, 'new_subject.php');

$menu_name = mysqli_real_escape_string($connection, $menu_name);
$position = mysqli_real_escape_string($connection, $position);
$visible = mysqli_real_escape_string($connection, $visible);

$query = "INSERT INTO subjects (menu_name, position, visible) VALUES ('{$menu_name}', {$position}, {$visible})"; //$position and $visible are numbers so no ''
if (do_query($query))
{
	redirect_to("Location: content.php");
}
mysqli_close($connection);
?>