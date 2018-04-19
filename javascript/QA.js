$(document).ready(function(){
	storager.set("timeout",1);

	//セッション破棄セット
	setTimeout(function(){
		storager.delete();
		storager.set("timeout",0);
	},30*60*1000)

		fn_register();

});

	function fn_register(){
	$('#sent').on('click',function(){
		//ボタンのプッシュは全部キャッチする。ボタンが増えたら分岐

		//ボタンを殺す
		$("#register_button").prop("disabled",true);
		//5秒後にボタンを復帰する
		setTimeout(function(){
			$("#register_button").prop("disabled",false);
		},5*1000)

		//ローカルストレージチェック
		if(!storager.get("timeout")){
			storager.delete();
			location.href="./session_timeout.html";
			return;
		}

		//登録処理ここから
		let QA={};

		//必要なクラスのオブジェクトを取得
		let c_QA = $(".c_QA");

		//フォームのオブジェクトのValueを取得
		//ラジオボタン取得用のkeyを設定
		let key ="";
		for(let i=0,len=c_QA.length; i<len; i++){
			key = $(c_QA[i]).attr("id");
			QA[key] = $(c_QA[i]).val();
		}

		storager.set("QA",QA);

		//配列の文字列化処理(登録画面遷移用)
		let confirm = JSON.stringify(QA);

		//encodeURIComponent(
		console.log(encodeURIComponent(encodeURIComponent(confirm)));
		location.href = "./QA_confirm.html?QA="+encodeURIComponent(encodeURIComponent(confirm));
	});
}