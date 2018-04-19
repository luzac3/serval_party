<?php
function mail_prop($user,$password,$address,$to_name){
	// メール情報
	// 一応仮で入れてありますが適宜変えて下さい。
	// メールホスト名
	define('MAIL_HOST','wolfnet-twei.sakura.ne.jp');

	// メールユーザー名・アカウント名
	define('MAIL_USERNAME',$user);

	// メールパスワード
	define('MAIL_PASSWORD',$password);

	 // SMTPプロトコル(sslまたはtls)
	define('MAIL_ENCRPT','tls');

	// 送信ポート(ssl:465, tls:587)
	define('SMTP_PORT', 587);

	// メールアドレス
	define('MAIL_FROM',$address);

	// 表示名
	//define('MAIL_FROM_NAME','アイティーエス');
	define('MAIL_FROM_NAME',$to_name);
}

function mailer_setting($mail_from,$mail_from_name){
	//PHPMailerの設定をしてインスタンスを返す
	$mail = new PHPMailer();

    $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    $mail->SMTPAuth = true;
    $mail->Host = MAIL_HOST; // メインのSMTPサーバーを指定する
    $mail->Username = MAIL_USERNAME; // SMTPユーザー名
    $mail->Password = MAIL_PASSWORD; // SMTPパスワード
    $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、 「SSL」も受け入れます
    $mail->Port = SMTP_PORT; // 接続するTCPポート

    // メール内容設定
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";
    $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);

	return $mail;
}