$(document).ready(function(){
	$("#make").on("click",function(){
		let login={};

		make["user"] = $("#user").val();
		make["passwd"] = $("#passwd").val();
		make["passwd_check"] = $("#passwd_check").val();
		make["mail"] = $("#mail").val();

		//usernumberのセット
		let dt = new Date();
		let month = dt.getMonth()+1;
		let day = dt.getDate();
		let year = dt.getFullYear();
		let hour = dt.getHours();

		month = String(month);
		day = String(day);
		hour = String(hour);
		year = String(year);

		if(month.length < 2){
			month = "0"+month;
		}
		if(day.length < 2){
			day = "0"+day;
		}
		if(hour.length < 2){
			hour = "0"+hour;
		}

		let a = Math.floor( Math.random() * (9 + 1 - 1) ) + 1 ;
		let b = Math.floor( Math.random() * (9 + 1 - 1) ) + 1 ;
		let c = Math.floor( Math.random() * (9 + 1 - 1) ) + 1 ;

		make["user_number"] = day + a + year + hour + b + month + c;

		if(make["passwd"] != make["passwd_check"]){
			$("#make_word").text("パスワードが一致しません");
			return;
		}

		$.ajax({
			url:"../php/new_admin.php",
			cache: false,
			timeout: 10000,
	        type:'POST',
	        dataType: 'json',
			data:{
				make:make
			}
		}).then(function(data){
			if(data == 1){
				location.href = "./admin_accept.html";
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