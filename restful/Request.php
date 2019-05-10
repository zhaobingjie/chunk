<?php
	/*请求接受类*/
	Class Request
	{
		//允许的请求方式
		private static $request_method = array('get','post','put','delete','patch');

		public static $method;

		public static $params;

		public function __construct(){
			self::$method = strtolower($_SERVER['REQUEST_METHOD']);
			if(in_array(self::$method,self::$request_method)){
				self::$params = $this->filter($_REQUEST);
			}
		}

		public function filter($data)
		{
			return $data;
		}
	}
	new Request();
?>