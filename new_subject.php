<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/pages/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php  include("includes/pages/navigation.php"); ?>
		</td>
		<td id="page">
			<h2>Add Subject</h2>
			<?php  
			if ($error = array_exists($_GET,'error', NULL)){
				echo "<div class=\"error\">Please fill in field {$_GET['error']}</div>";
			}
			?>
			<form action="create_subject.php" method="post">
				<p>Subject name: <input id="menu_name" type="text" name="menu_name" value="" /></p>
				<p>Position:
					<select name="position">
						<?php  
						$subject_set = get_all_subjects();
						$subject_count = mysqli_num_rows($subject_set) +1; //adding a row so we need position +1
						for ($count = 0; $count <= $subject_count; $count++){
							if ($count == 0){
								echo "<option value =\"\" disabled selected>Select</option>";
							}else{
								echo "<option value =\"{$count}\">{$count}</option>";
							}
						}
						?>
					</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" />No
					&nbsp;
					<input type="radio" name="visible" value="1" />Yes
				</p>
				<input type="submit" value="Add Subject" />
			</form>
			<br />
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/pages/footer.php"); ?>