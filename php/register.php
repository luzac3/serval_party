<?php
if(!empty($_POST["input"])){
	$input = $_POST["input"];
	require_once("./conection.php");
	$mysqli = db_connect("wolfnet-twei_party");

	$mysqli->set_charset("utf-8");
	if(input["match_select"]){
		$stmt = $mysqli -> prepare("SELECT * FROM REGISTER WHERE BIRTH = ?, AND JOINNER_NAME = ?");
	}else{
		$stmt = $mysqli -> prepare("SELECT * FROM REGISTER WHERE BIRTH = ?, AND JOINNER_NUMBER = ?");
	}

	$stmt->bind_param('is', $input["birth"], $input["match"]);

	$result = $stmt->execute();

	echo $result -> num_rows;

}else{
	echo 0;
}

?>