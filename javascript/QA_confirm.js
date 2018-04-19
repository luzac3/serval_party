$(document).ready(function(){
	//セッション(ストレージ)確認
	if(storager.check("QA")){
		locasion.href = "./session_timeout.html";
	}
	storager.set("timeout",1);

	//セッション破棄セット
	setTimeout(function(){
		storager.delete();
		storager.set("timeout",0);
	},30*60*1000)

	$("button").on("click",function(){
		//ローカルストレージチェック
		if(!storager.get("timeout")){
			storager.delete();
			location.href="./session_timeout.html";
			return;
		}

		//セッション取得
		let QA = storager.get("QA");

		//データ登録、メール送信用の関数
		$.when(db_register(QA),sendmail(QA))
			.then(function(db_data,sm_data){
				if(!db_data || !sm_data){
					location.href = "./QA_failue.html;"
				}else{
					location.href = "./QA_complete.html";
				}
			},
			function(){
				location.href = "./QA_failue.html;"
			});
	});
});

function sendmail(QA){
	//メール送信用
	$.ajax({
		type:"post",
		dataType:"json",
		url:"../php/QA_send_mail.php",
		data:{
			QA:QA
		}
	})
}

function db_register(QA){
	//DB登録用
	$.ajax({
		type:"post",
		dataType:"json",
		url:"../php/QA_db_register.php",
		data:{
			QA:QA
		}
	})

}
