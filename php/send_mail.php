<?php
require 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;


require "phpmailer/PHPMailerAutoload.php";
require 'mail_prop.php';


if(!empty($_POST["register"])){
	$register = $_POST["register"];

	//ファイル読み込み処理
	//アドレスはカンマ区切りのプロパティとして取得、配列にする
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

	//エラー通知用
	$mailError =mailer_setting(MAIL_FROM,MAIL_FROM_NAME);

	for($i = 0; $i < count($error_addr); $i++){
		$mailError->addAddress($error_addr[$i], $error_addr[$i]);
	}
	/*
	if(intval($register["REGISTER_CODE"])== 1 ){
		$consumer_key = "US1wRncfyzig9e3oF1KnK7WNG";
		$consumer_key_secret = "VXovfMbNcXkb0gZNP84EsOWITy45jN130padwVIHn3PvP0GRpP";
		$access_token ="918282399724707840-yzvE7PGgnNeQdZ3kui1NlrnBkhRck5f";
		$access_token_sequret = "tPM6OVfsW9LlT3V60V0wq5BYo4IJCRm1Jlgw2ku6mfSfK";

		$url = "statuses/update";

		$notes = "@" . $register["ADDRESS"]." 【受付番号】".$register["JOINNER_NUMBER"]."\n申込を受け付けました。
				申込情報を確認の上、一両日中にご連絡いたします。
				万一三日以上連絡がない場合、お手数ですが、https://wolfnet-twei.sakura.ne.jp/party/html/QA.htmlよりお問合せください。";

		//オブジェクトを生成
		$obj = new TwitterOAuth($consumer_key,$consumer_key_secret,$access_token,$access_token_sequret);

		$twResult = $obj->post($url,array("status" => $notes));

		$result = json_decode($twResult);

		if(isset($result->{'errors'}) && $result->{'errors'} != ''){
			//エラーメール送信処理
			$mailError->Subject = "[エラー]ツイート失敗";
			$mailError->Body  = "ツイート失敗\n対象\n登録者番号".$register["JOINNER_NUMBER"]."\n\n対象者:".$register["JOINNER_NAME"]."\nアカウント名:".$register["ADDRESS"];

			if(!$mailError->send()){
				echo 0;
				exit;
			}
		}

	}elseif(intval($register["REGISTER_CODE"])== 0 ){
*/
	if(intval($register["REGISTER_CODE"]) != 2 ){
		//本文を設定
		$str = $register["JOINNER_NAME"] . "様\n\n";
		$str .= "【登録番号】\n" . $register["JOINNER_NUMBER"] . "\n\n";
		$str .= "【アクリルスタンド申込】\n";

		if($register["JOINNER_NAME"] == 0){
			$str .= "あり";
		}else{
			$str .= "なし";
		}
		$str .= "\n\n";

		$str .= "【参加費】\n";
		$str .= $register["PRICE"] ."円\n\n";
		$str .= "このたびは、非公式イベント『サーバルケーキパーティ』への参加登録、まことにありがとうございます。\n";
		$str .= "内容確認後、主催より一両日中に折り返しご連絡をさせていただきますので、今しばらくお待ちください。\n";
		$str .= "万一三日以上ご連絡がない場合、大変お手数ですが、以下のフォームよりご連絡ください\n";
		$str .= "https://wolfnet-twei.sakura.ne.jp/party/html/QA.html\n\n";

		$str .= "-------------------------------------------------------------\n";
		$str .= "■登録情報の確認\n";
		$str .= "https://wolfnet-twrei.sakura.ne.jp/party/html/confirm.html\n\n";

		$str .= "■お問い合わせ\n";
		$str .= "https://wolfnet-twei.sakura.ne.jp/party/html/QA.html\n\n";

		$str .= "-------------------------------------------------------------\n\n";
		$str .= "このメールにお心当たりの無い方は、お手数ですが当メールを破棄していただきますようお願い申し上げます\n\n";

		$str .= "※このメールは送信専用のメールアドレスから配信されています。\n";
		$str .= "ご返信いただいてもお返事できませんのでご了承ください。\n\n";

		$str .= "---------------------------------\n";

		$str .= "サーバルケーキパーティ企画部\n\n";

		$str .= "主催：luza\n\n";

		$str .= "https://wolfnet-twei.sakura.ne.jp/party/html\n";

		$str .= "---------------------------------\n";


	    $mail->addAddress($register["ADDRESS"], $register["JOINNER_NAME"]); //受信者を追加する
	    //$mail->addCC（$account["inquiry_addr"]）; // CCで追加
	    $mail->addBcc($account["inquiry_addr"]); // BCCで追加
	    $mail->Subject = "サーバルケーキパーティ　申込受付"; // メールタイトル
	    //$mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します

    	$mail->Body  = $str;

	    // メール送信の実行
	    if(!$mail->send()) {
	        echo 0;
	        exit;
	    }
	}

	//管理者向け登録通知メール送信
	$mailAdmin->Subject = "サーバルケーキパーティ　申込受領";
	$mailAdmin->Body  = "パーティ申し込みがありました\n登録者番号".$register["JOINNER_NUMBER"];

	if(!$mailAdmin->send()) {
	      echo 0;
	    exit;
	}

	echo 1;
}else{
	echo 0;
}


?>