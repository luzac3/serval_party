<?php
	if(!empty($_POST["QA"])){
		$QA = $_POST["QA"];
		require_once("./conection.php");
		$mysqli = db_connect("wolfnet-twei_party");

		$sql = "INSERT INTO QA ";

		$sql .= "(
				name,
				title,
				address,
				content
				)";

		$sql .= " VALUES ";

		$sql .= "(";


		$sql .= "'".$QA["name"]."',";

		$sql .= "'".$QA["title"]."',";

		$sql .= "'".$QA["address"]."',";

		$sql .=	"'".$QA["content"]."'";

		$sql .= ')';

		if($mysqli -> query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
?>
