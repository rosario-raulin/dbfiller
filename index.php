<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Filling the DB...</title>
	</head>
	<body>
		<p>
		<?php
			require "DBFiller.php";

			try {
				$filler = new DBFiller();
				$leftout = $filler->fill("entries.txt");

				if ($leftout == 0) {
					echo "Added all entries.";
				} else {
					echo $leftout . " entries left out.";
				}
			} catch (Exception $e) {
				die($e);
			}
		?>
		</p>
	</body>
</html>

