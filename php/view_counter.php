<?php
class ViewCounter
{
	const SALT = 'hello_world.12345';
	private $log_dir;
	private $db_dir;

	function __construct($log_dir=null, $db_dir=null){
		//ログディレクトリ設定
		$this->log_dir    = is_null($log_dir) ? dirname(__FILE__) . '/log/' : $log_dir;
		$this->db_dir     = is_null($db_dir)  ? dirname(__FILE__) . '/db/' : $db_dir;
	}

	//IPをチェックしてカウントを増やす
	function log($id){
		$ip = date("Ymd_") . md5($this::SALT . $_SERVER['REMOTE_ADDR']);

		$file = $this->log_dir . $id . '_' . md5($this::SALT . $id) . '.log';

		$data = array();
		$flag = true;

		$fp = fopen($file, 'a+b');
		flock($fp, LOCK_EX);

		//直近100件までを読み込む
		for($i=0;$i<100;$i++){
			if(feof($fp)) break;
			$line = fgets($fp);
			if($ip === rtrim($line)){
				$flag = false;
				break;
			} else {
				$data[] = $line;
			}
		}

		if($flag){
			array_unshift($data, $ip . "\n");
			ftruncate ($fp, 0);
			rewind($fp);
			foreach($data as $value){
				fwrite($fp, $value);
			}
		}

		fflush($fp);
		flock($fp, LOCK_UN);
		fclose($fp);

		if($flag){
			$count = $this->count_up($id);
		} else {
			$count = $this->get_count($id);
		}

		return $count;
	}

	//データベースのカウントを増やす
	function count_up($id, $num=1){
		$file = $this->db_dir . $id . '_' .md5($this::SALT . $id) . '.log';

		if(file_exists($file)){
			$count = (int)file_get_contents($file);
		} else {
			$count = 0;
		}

		if($num > 0){
			$count = $count + $num;
			file_put_contents( $file, $count, LOCK_EX );
		}
		return $count;
	}

	//データベースのカウントを得る
	function get_count($id){
		$count = $this->count_up($id, 0);
		return $count;
	}
}
?>