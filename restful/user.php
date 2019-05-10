<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING);
	/*处理类*/
	require_once './Request.php';
	require_once './Response.php';
	// var_dump($_REQUEST);exit;
	Class User
	{
		public $db_data = array(
			1	=>	array('name'=>'jack','age'=>18,'sex'=>1),
			2	=>	array('name'=>'nancy','age'=>18,'sex'=>0),
		);
		
		public function __construct(){
			$method =  Request::$method;

			if(Request::$method){
				$func_name = Request::$method.'Data';
				$this->$func_name();
			}
		}

		//GET::查询
		public function getData(){
			$id = Request::$params['id'];
			if($id){
				if($this->db_data[$id]){
					$return['user'] = $this->db_data[$id];
					// Response::send($return,array('content_type'=>'application/xml'));
					Response::send($return);
				}else{
					Response::send('error data');
				}
			}else{
				$return['user'] = $this->db_data;
				$return['total'] = count($return['user']);
				// Response::send($return,array('content_type'=>'application/xml'));
				Response::send($return);
			}
		}
		//POST::新增
		public function postData(){
			$data[] = Request::$params;
			$return = array_merge($this->db_data,$data);
			Response::send($return);
		}
		//PUT::更新
		public function putData(){
			$params = Request::$params;
			$id = $params['id'];
			if($id && $this->db_data[$id]){
				if($params['name']){
					$this->db_data[$id]['name'] = $params['name'];
				}
				if($params['age']){
					$this->db_data[$id]['age'] = $params['age'];
				}
				if($params['sex']){
					$this->db_data[$id]['sex'] = $params['sex'];
				}
				$return = $this->db_data[$id];
				Response::send($return);
			}else{
				Response::send('error data');
			}
		}
		//PATCH::局部更新
		public function patchData(){
			$params = Request::$params;
			$id = $params['id'];
			if($id && $this->db_data[$id]){
				if($params['name']){
					$this->db_data[$id]['name'] = $params['name'];
				}
				$return = $this->db_data[$id];
				Response::send($return);
			}else{
				Response::send('error data');
			}
		}
		//DELETE::删除
		public function deleteData(){
			$params = Request::$params;
			$id = $params['id'];
			if($id && $this->db_data[$id]){
				unset($this->db_data[$id]);
				$return = $this->db_data;
				Response::send($return);
			}else{
				Response::send('error data');
			}
		}
	}
	new User();
?>
