<?php
require "phpmailer/PHPMailerAutoload.php";
require 'mail_prop.php';

if(!empty($_POST["QA"])){
	$QA = $_POST["QA"];

	//ファイル読み込み処理
	$account = parse_ini_file("./property.ini");

	//管理者メール送信対象アドレス分割処理
	$note_addr = explode(",",$account["note_addr"]);
	$error_addr = explode(",",$account["error_addr"]);

	//送信元情報
	$from_name = "サーバルケーキパーティ企画部";
	$from = $account["info_addr"];

	//ユーザーへのメール送信用
	mail_prop($from,"alderaan123",$from,$from_name);
	$mail = mailer_setting(MAIL_FROM,MAIL_FROM_NAME);

	// 管理者への送信用
	$mailAdmin =mailer_setting(MAIL_FROM,MAIL_FROM_NAME);

	for($i = 0; $i < count($note_addr); $i++){
	    $mailAdmin->addAddress($note_addr[$i], $note_addr[$i]);
	}
/*
	//エラー通知用
	$mailError =mailer_setting(MAIL_FROM,MAIL_FROM_NAME);

	for($i = 0; $i < count($error_addr); $i++){
	    $mailError->addAddress($error_addr[$i], $error_addr[$i]);
	}
*/
	//本文を設定
	$str .= "お問合せありがとうございます。\n";
	$str .= "内容確認後、主催より一両日中に折り返しご連絡をさせていただきますので、今しばらくお待ちください。\n\n";
	//リンク

	$str .= "------------------------------\n";
	$str .= "このメールにお心当たりの無い方は、お手数ですが当メールを破棄していただきますようお願い申し上げます。\n\n";

	$str .= "※このメールは送信専用のメールアドレスから配信されています。\n";
	$str .= "ご返信いただいてもお返事できませんのでご了承ください。\n\n";
	$str .= "------------------------------\n\n";
	$str .= "サーバルケーキパーティ主催：luza";

	$mail->addAddress($QA["address"], $QA["name"]); //受信者を追加する
	$mail->addBcc($account["inquiry_addr"]); // BCCで追加
	$mail->Subject = "サーバルケーキパーティ　お問合せ受付"; // メールタイトル

	$mail->Body  = $str;

	// メール送信の実行
	if(!$mail->send()) {
	    echo 0;
	    exit;
	}

	//管理者向け登録通知メール送信
	$mailAdmin->Subject = "サーバルケーキパーティ　問合せ受領【" . $QA["title"] ."】";
	$mailAdmin->Body  = "【お問合せ内容】\n\n".$QA["content"];

	if(!$mailAdmin->send()) {
	    echo 0;
	    exit;
	}

	echo 1;
}else{
	echo 0;
}
?>