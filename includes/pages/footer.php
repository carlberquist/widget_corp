	</div>
	<div id = "footer">Copyright 2007, Widget Corp</div>
</body>
</html>
<?php
    global $connection;
    if (isset($connection)) {
        mysqli_close($connection);
    }
?>
