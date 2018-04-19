<?php
include_once 'view_counter.php';
require_once("./conection.php");
$mysqli = db_connect("wolfnet-twei_party");

if(!empty($_POST["id"])){
	$logger = new ViewCounter("./ip/","./count/");
	$id = $_POST["id"];

	//ロガーセット
	$count = $logger->log( $id );

	$date = Date("Ymd");

	$sql = "SELECT * FROM COUNTER WHERE DATE = ?";

	$mysqli->set_charset("utf-8");

	$stmt = $mysqli -> prepare($sql);

	$stmt->bind_param('i', $date);

	$stmt->execute();

	//結果セット取得
	$stmt->store_result();

	$result = $stmt -> num_rows;

	if($result != 0){
		/*
		//結果を格納
		$result = $stmt->get_result();
		while($row = $result -> fetch_assoc()){
			$now_ID = $row["ID"];
		}
		$now_ID++;
		*/
		$sql = "UPDATE COUNTER SET VIEW = ? WHERE DATE = ?";

		$stmt = $mysqli -> prepare($sql);

		$stmt->bind_param('ii', $count,$date);
	}else{
		$sql = "INSERT INTO COUNTER (DATE, VIEW) VALUES (?, ?)";
		$stmt = $mysqli -> prepare($sql);
		$stmt->bind_param('ii', $date, $count);
	}
	if(!$stmt->execute()){
		echo json_encode($sql);
	}else{
		echo 1;
	}

}else{
	echo 0;
}

?>