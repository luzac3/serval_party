<?php
require "phpmailer/PHPMailerAutoload.php";
require 'mail_prop.php';

if(!empty($_POST)){
    //ファイル読み込み処理
    //アドレスはカンマ区切りのプロパティとして取得、配列にする
    $account = parse_ini_file("./property.ini");

    //管理者メール送信対象アドレス分割処理
    $note_addr = explode(",",$account["note_addr"]);
    $error_addr = explode(",",$account["error_addr"]);

    //送信元情報
    $from_name = "サーバルケーキパーティ企画部";
    $from = $account["info_addr"];

    // 管理者への送信用
    $mailAdmin =mailer_setting(MAIL_FROM,MAIL_FROM_NAME);

    for($i = 0; $i < count($note_addr); $i++){
        $mailAdmin->addAddress($note_addr[$i], $note_addr[$i]);
    }

    //POST情報キャッチ
	$make = $_POST["make"];

	require_once("./conection.php");
	$mysqli = db_connect();

	$str  = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'),array(".","/"));

	$salt = "$2y$10$";

	for($i=0; $i<22; $i++){
		$salt .= $str[rand(0,count($str)-1)];
	}

	$salt .= "$";

	$hash = crypt($make["passwd"], $salt);

	//$sql="INSERT INTO login (user_name,hash,make_date) VALUES ('".$username."','".$hash."','".$date."')";
	$sql="INSERT INTO login (ADMIN_ID,ADMIN_NAME,ADMIN_NUMBER,hash,ADDRESS,ATHRZ_CODE,) VALUES (NULL, ?, ?, ?, ?, '0')";

	$stmt = $mysqli -> prepare($sql);

	$stmt->bind_param('ssss',$make["user"], $make["user_number"], $hash,$make["mail"]);

	if($stmt->execute()){
	    //メール送信
	    //管理者向け登録通知メール送信
	    $mailAdmin->Subject = "管理者登録";
	    $mailAdmin->Body  = "管理者の登録がありました\n登録者番号".$register["ADMIN_NUMBER"];

	    if(!$mailAdmin->send()) {
	        echo json_encode("メール送信失敗");
	        exit;
	    }
		echo json_encode("ユーザー作成受付");
		//echo ("ユーザー作成完了");
	}else{
		echo json_encode("通信失敗");
		//echo ($sql);
	}

}else{
	echo json_encode("作成失敗");
}

?>