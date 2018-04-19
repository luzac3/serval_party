<?php
	if(!empty($_POST["register"])){
		$register = $_POST["register"];

		require_once("./conection.php");
		$mysqli = db_connect("wolfnet-twei_party");


		//日時取得処理
		$register["REGISTER_DATE"] = date("YmdHis");
		$sql = "INSERT INTO REGISTER ";
		$sql .= "(
				JOINNER_NAME,
				JOINNER_NUMBER,
				REGISTER_CODE,
				FRIENDS_ID,
				TWITTER_ACOUNT_FLAG,
				TWITTER_ACOUNT,
				MAIL_ADDRESS_FLAG,
				MAIL_ADDRESS,
				PRIORITY_ADDRESS,
				REGISTER_DATE,
				BIRTH,
				UNDERAGE_FLAG,
				PRICE,
				ACRYLIC_FLAG,
				DISPLAY_FLAG,
				DISPLAY_NUM,
				TRADE_FLAG,
				TRADE_NUM,
				PRISE_FLAG,
				PRISE_NUM,
				ALCHOL_FLAG,
				ALCHOL_NUM,
				LOVE_FRIENDS,
				COSTUME_FLAG,
				COMMENT,
				ADMIN_FLAG,
				STATUS
				)";

		$sql .= " VALUES ";

		$sql .= "(";

		$sql .= "'".$register["JOINNER_NAME"]."',";

		$sql .= "'".$register["JOINNER_NUMBER"]."',";

		$sql .= $register["REGISTER_CODE"].',';

				if($register["REGISTER_CODE"] == 2){
					$sql .= "'".$register["ADDRESS"]."',";
				}else{
					$sql .= 'NULL,';
				}

				if($register["REGISTER_CODE"] != 2){
					$sql .= '1' .',';
					$sql .= "'".$register["ADDRESS"]."',";
				}else{
					$sql .= '0' .',';
					$sql .= 'NULL,';
				}

				if($register["TWITTER"] != ""){
					$sql .= '1' .',';
					$sql .= "'".$register["TWITTER"]."',";
				}else{
					$sql .= '0' .',';
					$sql .= 'NULL,';
				}

				$sql .= $register["REGISTER_CODE"] .',';

				$sql .= $register["REGISTER_DATE"].',';

				$sql .= '"'.$register["BIRTH"].'",';

				if($register["BIRTH"] + 150000 > date("Ymd")){
					$sql .= '1' .',';
				}else{
					$sql .= '0' .',';
				}

				$sql .= $register["PRICE"].',';

				$sql .= $register["ACRYLIC_FLAG"].',';

				$sql .= $register["DISPLAY_FLAG"].',';

				if($register["DISPLAY_NUM"] == ""){
					$sql .= "0".",";
				}else{
					$sql .= $register["DISPLAY_NUM"].',';
				}

				//$sql .= $register["TRADE_FLAG"].',';
				$sql .= "0".",";

				//$sql .= $register["TRADE_NUM"].',';
				$sql .= "NULL".",";

				$sql .= $register["PRISE_FLAG"].',';

				if($register["PRISE_NUM"] == ""){
					$sql .= "0".",";
				}else{
					$sql .= $register["PRISE_NUM"].',';
				}

				$sql .= $register["ALCHOL_FLAG"].',';

				if($register["ALCHOL_NUM"] == ""){
					$sql .= "0".",";
				}else{
					$sql .= $register["ALCHOL_NUM"].',';
				}

				$sql .= "'".$register["LOVE_FRIENDS"]."',";

				$sql .= $register["COSTUME"].',';

				$sql .= "'".$register["COMMENT"]."',";

				$sql .= '0'.',';

				$sql .= '"0"';

				$sql .= ')';

		if($mysqli -> query($sql)){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}

?>