<?php
if(!empty($_POST)){
	$user = $_POST["user"];
	$passwd = $_POST["passwd"];


	require_once("./conection.php");
	$mysqli = db_connect("wolfnet-twei_party");

	$stmt = $mysqli -> prepare("SELECT * FROM admin WHERE user_name = ? LIMIT 1");

	$stmt->bind_param('s', $user);

	$stmt -> execute();

	//結果セット取得
	$stmt->store_result();

	if(($stmt -> num_rows)<1){
		echo 0;
		return;
	}
	//結果を格納
	$result = $stmt->get_result();

	while($row = $result -> fetch_assoc()){
        $hash = $row["hash"];
	}

	// パスワードを検証する
	if (hash_equals($hash,crypt($passwd, $hash))) {
	    echo 1;
	} else {
		//パスワード間違いに関してはコード値が必要
	    echo 2;
	}
}else{
	echo 0;
}

?>