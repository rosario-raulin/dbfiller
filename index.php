<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Filling the DB...</title>
	</head>
	<body>
		<p>
		<?php
			error_reporting(E_ALL);
			ini_set('display_errors', '1');

			require "DBFiller.php";

			try {
				if ($added == 0) {
					echo "Added all entries.";
				} else {
					echo $added . " entries left out.";
				}
			} catch (Exception $e) {
				die($e);
			}
		?>
		</p>
	</body>
</html>

