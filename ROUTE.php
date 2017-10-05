<?php
    /**
     * Class ROUTE
     * author : mahdi khanzadi
     * year: 2017--1397 winter
     * my blog: http://tarhche.com
     * email: khanzadimahdi@gmail.com
    **/
	class ROUTE{
		public static $methods=array();
		public static $uri;
		public static $action;
		public static $attrs=array();
		public static $params=array();
		public static $founded=false;
		public static $hookFunctions=array();

		public static function addHookFunction(callable $function){
            array_push(self::$hookFunctions,$function);
        }

        public static function runHookFunctions($data){
            if(!empty(self::$hookFunctions)){
                foreach(self::$hookFunctions as $hookFunction){
                    call_user_func_array($hookFunction,array($data));
                }
            }
        }

		public static function findMethod($methodPattern){
			$request_method=strtolower($_SERVER['REQUEST_METHOD']);
			if(preg_match("/$methodPattern/i",$request_method,self::$methods)){
				return self::$methods;
			}
			return false;
		}

		public static function findURI(){
			$uri=empty($_GET['uri']) ? '/' : $_GET['uri'];
			if(substr($uri,-1) == "/"){
				$uri = substr($uri,0,-1);
			}
			$uri = explode("/",$uri);
			self::$uri=$uri;
			return $uri;
		}

		public static function normalURI($uri){
			if($uri[0] == "/"){
				$uri = substr($uri,1);
			}
			if(substr($uri,-1) == "/"){
				$uri = substr($uri,0,-1);
			}
			return $uri;
		}
	
		public static function findParams($definedPath,$uri){
			$definedPath = self::normalURI($definedPath);
			$definedPathParams = explode("/",$definedPath);
			$i=0;
			foreach($definedPathParams as $param){
				if(preg_match("/\{(\S+)\}/",$param)){
					if(strpos($param,':')>0){
						//remove {} from string
						if($param[0] == "{"){
							$param = substr($param,1);
						}
						if(substr($param,-1) == "}"){
							$param = substr($param,0,-1);
						}
						$param=explode(':',$param,2);
						if(preg_match("/$param[1]/i",self::$uri[$i])){
							array_push(self::$attrs,$uri[$i]);
						}
					}else{
						array_push(self::$attrs,$uri[$i]);
					}
				}else{
					array_push(self::$params,$param);
				}
				$i++;
			}
		}

		public static function matchCheck($definedPath){
			$definedPath = self::normalURI($definedPath);
			$definedPathParams = explode("/",$definedPath);
			if(count($definedPathParams) == count(self::$uri)){
				for($i = 0; $i < count($definedPathParams); $i++){
					if(preg_match("/\{(\S+)\}/",$definedPathParams[$i])){
						if(strpos($definedPathParams[$i],':')>0){
							//remove {} from string
							if($definedPathParams[$i][0] == "{"){
								$definedPathParams[$i] = substr($definedPathParams[$i],1);
							}
							if(substr($definedPathParams[$i],-1) == "}"){
								$definedPathParams[$i] = substr($definedPathParams[$i],0,-1);
							}
							$definedPathParams[$i]=(explode(':',$definedPathParams[$i],2));
							$regex=($definedPathParams[$i][1]);
							if(preg_match("/$regex/i",self::$uri[$i])){
								$definedPathParams[$i] = self::$uri[$i];									
							}
						}else{
							$definedPathParams[$i] = self::$uri[$i];
						}
					}
				}
			}
			return $definedPathParams;
		}

		public static function commandRun(callable $action,array $args){
            self::runHookFunctions(array('uri'=>self::$uri,'params'=>self::$params,'action'=>$action,'args'=>$args));
			if(self::$founded){
				$result=(call_user_func_array($action,$args));
				if(!empty($result)){
					echo $result;
				}
			}
		}

		public static function go($methodPattern,$uri,callable $action){
			if(self::findMethod($methodPattern)){
				foreach(self::$methods as $method){
					if(is_callable(array(__CLASS__,$method))){
						if(call_user_func(array(__CLASS__,$method),$uri,$action)){
							return true;
						}
					}
				}
			}
			return false;
		}

		public static function get($uri,callable $action){
			$request_method=strtolower($_SERVER['REQUEST_METHOD']);
			if($request_method=='get'){
				self::findURI();
				$definedPathParams=self::matchCheck($uri);
				if($definedPathParams == self::$uri){
					self::findParams($uri,self::$uri);
					self::$founded=true;
					self::commandRun($action,self::$attrs);
					return true;
				}
			}
		}

		public static function post($uri,callable $action){
			$request_method=strtolower($_SERVER['REQUEST_METHOD']);
			if($request_method=='post'){
				self::findURI();
				$definedPathParams=self::matchCheck($uri);
				if($definedPathParams == self::$uri){
					self::findParams($uri,self::$uri);
					self::$founded=true;
					self::commandRun($action,self::$attrs);
					return true;
				}
			}
		}
	}
?>