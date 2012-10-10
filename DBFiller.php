<?php
	require "config.php";

	class DBFiller {

		protected $db_con;

		public function __construct() {
			$this->db_con = new mysqli($GLOBALS['db_host'],	$GLOBALS['db_user'],
					$GLOBALS['db_pass'], $GLOBALS['db_name']);

			if ($this->db_con->connect_error != NULL) {
				throw new Exception($this->db_con->connect_error);
			}

			if (!$this->db_con->set_charset("utf8")) {
				throw new Exception("could not load utf8 charset");
			}
		}

		protected function parseInput($path) {
			if ($fd = fopen($path, "r")) {
				$res = array();

				for ($i = 0; ($mail = fgets($fd)) != NULL; ++$i) {

					if (($lname = fgets($fd)) == NULL ||
							($fname = fgets($fd)) == NULL) {
						throw new Exception("input file format error");
					}

					$mail = trim($mail);
					$lname = trim($lname);
					$fname = trim($fname);

					$res[$i] = array("mail" => $mail, "lastname" => $lname,
						"firstname" => $fname);
				}
				fclose($fd);
				return $res;
			} else {
				throw new Exception("could not open file");
			}
		}

		public function fill($path) {
			$inp = $this->parseInput($path);
			$con = $this->db_con;
			$added = 0;
			foreach ($inp as $v) {
				if ($stmt = $con->prepare("INSERT INTO users VALUES (?, ?, ?)")) {
					$stmt->bind_param("sss", $v["mail"], $v["lastname"], $v["firstname"]);
					if ($stmt->execute()) { ++$added; }
					$stmt->close();
				}
			}
			return count($inp) - $added;
		}

		public function __destruct() {
			if ($this->db_con->connect_error == NULL) {
				$this->db_con->close();
			}
		}
	}
?>

