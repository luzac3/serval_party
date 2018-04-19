$(document).ready(function(){
	$("button").on("click",function(){
		//ボタンを殺す
		$("#register_button").prop("disabled",true);
		//5秒後にボタンを復帰する
		setTimeout(function(){
			$("#register_button").prop("disabled",false);
		},5*1000)

		//入力情報取得
		let input={};

		let c_register = $(".c_register");

		input["birth"] = parseInt(String($(c_register[0]).val()) + String($(c_register[1]).val()) + String($(c_register[2]).val()));
		input["match_select"] = parseInt($("input[name='num_name']:checked").val());
		input["match"] = $("#match").val();

		//子ウィンドウを別で作成
		let childWindow = window.open('about:blank');

		matching(input).then(function(data){
			if(data){
				//配列の文字列化処理(登録画面遷移用)
				let info = JSON.stringify(input);

				//encodeURIComponent(
				childWindow.location.href = "./register_info.html?register="+encodeURIComponent(encodeURIComponent(info));
				childWindow = null;
			}else{
				//マッチ失敗処理
				$("#matching_word").html("認証に失敗しました。入力内容を確認してください。<br>入力内容に誤りがない場合、エラーの可能性がございます。<br><a href='./QA.html'>こちら</a>からご連絡いただけますようお願いいたします");
			}
		},
		function(){
			$("#matching_word").html("未知のエラーが発生しました。<br>しばらく待ってもエラーが直らない場合は、お手数ですが<a href='./QA.html'>こちら</a>から管理者にご連絡ください");
			childWindow.close();
			childWindow = null;
		});
	})
});

function matching(input){
	//登録内容とのマッチング
	return $.ajax({
		url:"../php/matching.php",
		cache: false,
		timeout: 10000,
        type:'POST',
        dataType: 'json',
		data:{
			input:input
		}
	})
}