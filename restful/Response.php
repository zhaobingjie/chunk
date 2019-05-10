<?php
/*输出类*/

Class Response
{
	const HTTP_SERVER = 'HTTP/1.1';

	public static $instance;

	public static final function getInstance(){
		if(!self::$instance){
			self::$instance = new Response();
		}
		return self::$instance;
	}

	public static function send($data,$header=''){
		if(empty($data)) return false;
		if($data){
			$code = 200;
			$message = 'ok';
		}else{
			$code = 404;
			$message = 'NOT FOUND';
		}
		header(self::HTTP_SERVER.' '.$code.' '.$message);
		if($header['content_type']){
			$content_type = $header['content_type'];
		}else{
			$con_arr = explode(',',$_SERVER['HTTP_ACCEPT']);
			$content_type = reset($con_arr);
 		}
 		header('Content-Type:'.$content_type);
 		if($content_type == 'application/json'){
 			echo self::getInstance()->encode_json($data);
 		}elseif($content_type == 'application/xml'){
 			echo self::getInstance()->encode_xml($data);
 		}else{
 			var_dump($data);
 		}
	}

	public function encode_json($data){
		return json_encode($data);
	}

	public function encode_xml($data){
		$xml = '<?xml version="1.0" encoding="utf-8" ?>';
		$xml .= $this->arrtoXml($data);
		return $xml;
	}

	public function arrtoXml($arr,$ele='root'){
		$xml = '<'.$ele.'>';
		foreach ($arr as $key => $val) {
			if (is_array($val)) {
				if(is_numeric($key)) $key = $ele.$key ;
				$xml .= $this->arrtoXml($val,$key);
			} else {
				$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
			}
		}
		$xml .= '</'.$ele.'>';
		return $xml;
	}
}
?>