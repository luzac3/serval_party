$(document).ready(function(){
	$("#login").on("click",function(){
		let login={};

		login["user"] = $("#user").val();
		login["passwd"] = $("#passwd").val();

		$.ajax({
			url:"../php/login.php",
			cache: false,
			timeout: 10000,
	        type:'POST',
	        dataType: 'json',
			data:{
				login:login
			}
		}).then(function(data){
			if(data == 1){
				location.href = "./admin_menu.html";
			}else if(data ==2){
				//エラー
				$("#login_word").text("認証に失敗しました。入力内容を確認してください。<br>入力内容に誤りがない場合、エラーの可能性がございます。<br><a href='./QA.html'>こちら</a>からご連絡いただけますようお願いいたします");
			}
			if(!data){
				$("#login_word").text("未知のエラーが発生しました。<br>しばらく待ってもエラーが直らない場合は、お手数ですが<a href='./QA.html'>こちら</a>から管理者にご連絡ください");
			}
		},
		function(){
			$("#login_word").text("未知のエラーが発生しました。<br>しばらく待ってもエラーが直らない場合は、お手数ですが<a href='./QA.html'>こちら</a>から管理者にご連絡ください");
		});
	});
});