$(document).ready(function(){
	//セッション(ストレージ)確認
	if(!storager.check("register")){
		location.href = "./session_timeout.html";
	}
	storager.set("timeout",1);

	//セッション破棄セット
	setTimeout(function(){
		storager.set("timeout",0);
	},30*60*1000)

	$("#register_button").on("click",function(){
		//ローカルストレージチェック
		if(!storager.get("timeout")){
			storager.delete();
			location.href="./session_timeout.html";
			return;
		}

		//セッション取得
		let register = storager.get("register");
		console.log(register);
		//データ登録、メール送信用の関数
		db_register(register).then(function(db_data){
			if(db_data){
				sendmail(register).then(function(sm_data){
					if(sm_data){
						console.log(sm_data);
						console.log(db_data);
						location.href = "./register_success.html?JOINNER_NUMBER="+register["JOINNER_NUMBER"];
					}else{
						console.log("4");
						location.href = "./register_failue.html";
					}
				},function(){
					console.log("3");
					location.href = "./register_failue.html";
				});
			}else{
				console.log("2");
				location.href = "./register_failue.html";
			}
		},function(){
			console.log("1");
			location.href = "./register_failue.html";
		});
	});

	$("#back_button").on("click",function(){
		location.href = "./register.html";
	})
});
function sendmail(register){
	//メール送信用
	return $.ajax({
		url:"../php/send_mail.php",
		cache: false,
		timeout: 10000,
        type:'POST',
        dataType: 'json',
		data:{
			register:register
		}
	})
}

function db_register(register){
	//DB登録用
	return $.ajax({
		url:"../php/db_register.php",
		cache: false,
		timeout: 10000,
        type:'POST',
        dataType: 'json',
		data:{
			register:register
		}
	})

}
