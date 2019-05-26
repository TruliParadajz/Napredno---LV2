<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>2</title>	
</head>
<body>
	<div>
		<form method="post" action="index.php" enctype="multipart/form-data">
			<div>
				<input type="file" name="image">
			</div>
			<div>
				<input type="submit" name="upload" value="Upload">
			</div>
		</form>
	</div>
	<form method="post" action="index.php" enctype="multipart/form-data">
		<div>
			<input type="submit" name="fetch" value="Get images">
		</div>
	</form>

	<?php
		include("upload.php");
		echo "<p>Files:</p>";
		include("fetch.php");
	?>

</body>
</html>