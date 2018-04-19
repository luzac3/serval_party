
$(document).ready(function(){
	//ボタン非活性化
	$("#register_button").prop("disabled",true);

	//必須入力チェック起動処理
	$("form").on("input",function(){
		if(this.checkValidity()){
			$("#register_button").prop("disabled",false);
		}else{
			$("#register_button").prop("disabled",true);
		}
	});

	//バルーン等Hide処理
	$(".hide").hide();

	//必須チェック表示処理

	//画面遷移確認
	if(storager.check("register")){
		let register = storager.get("register");
		//値をセット
		let c_register = $(".c_register");

		//フォームのオブジェクトのValueを取得
		//ラジオボタン取得用のkeyを設定
		let key ="";
		for(let i=0,len=c_register.length; i<len; i++){
			key = $(c_register[i]).attr("id");
			if($("#"+key)[0].value === undefined){
				$("input[name='"+key+"']").val([register[key]]);
			}else{
				$("#"+key).val(register[key]);
			}
		}
	}

	//起動段階でもチェック
	if($("#ADDRESS")[0].checkValidity()){
		$("#register_button").prop("disabled",false);
	}else{
		$("#register_button").prop("disabled",true);
	}

	//友人登録処理
	$("#REGISTER_CODE").on("change",function(){
		//アドレス内容書き換え処理
		if($("input[name=REGISTER_CODE]:checked").val() == "2"){
			$("#ADDRESS").prop("disabled",true);
			$("#TWITTER").prop("disabled",true);
		}else{
			if($("#ADDRESS")[0].checkValidity()){
				$("#register_button").prop("disabled",false);
			}else{
				$("#register_button").prop("disabled",true);
			}
			$("#ADDRESS").prop("disabled",false);
			$("#TWITTER").prop("disabled",false);
		}
	});

	//セッション破棄(30分)
	setTimeout(function(){
		storager.delete();
		storager.set("timeout",0);
	},30*60*1000)

	storager.set("timeout",1);
	try {
		fn_register();
	} catch (e){
		location.href = "./register_failue.html";
	}

});

	function fn_register(){
	$('#button_set').on('click','#register_button',function(){
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
		let register={};

		//登録費をデフォルト値に設定
		register["PRICE"]=4500;

		//必要なクラスのオブジェクトを取得
		let c_register = $(".c_register");

		//フォームのオブジェクトのValueを取得
		//ラジオボタン取得用のkeyを設定
		let key ="";
		for(let i=0,len=c_register.length; i<len; i++){
			key = $(c_register[i]).attr("id");
			console.log($("#"+key).val());
			console.log($("#"+key)[0].value);
			if($("#"+key)[0].value === undefined){
				register[key] = $("input[name='"+key+"']:checked").val();
			}else{
				register[key] = $("#"+key).val();
			}
		}

		//参加費を変更
		if(register["ACRYLIC_FLAG"]=="1"){
			register["PRICE"] += 1000;
		}

		if(register["DISPLAY_NUM"] >=5 || register["PRISE_NUM"] >= 2 || register["PRISE_NUM"] >= 1){
			register["PRICE"] -= 500;
		}

		//誕生日を編集
		if(register["birthM"].length < 2){
			register["birthM"] = "0" + register["birthM"];
		}
		if(register["birthD"].length < 2){
			register["birthD"] = "0" + register["birthD"];
		}
		register["BIRTH"] = register["birthY"]+register["birthM"]+register["birthD"];

		//登録番号を設定
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

		register["JOINNER_NUMBER"] = day + a + year + hour + b + month + c;


		for(let key in register){
			if(isNaN(register[key])){
				continue;
			}
			if(parseInt(register[key])){
				register[key] = parseInt(register[key]);
			}
		}

		storager.set("register",register);
		console.log(register);
		console.log(JSON.stringify(register));

		//配列の文字列化処理(登録画面遷移用)
		let confirm = JSON.stringify(register);

		//encodeURIComponent(
		console.log(encodeURIComponent(encodeURIComponent(confirm)));
		location.href = "./register_confirm.html?register="+encodeURIComponent(encodeURIComponent(confirm));
	});
}



function fnsession(){
	let bool = true;
	let tf = function(set_bool){
		bool === undefined ? bool : set_bool;
		return bool;
	}
	return tf;
}