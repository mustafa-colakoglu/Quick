<?php
	namespace Q;
	class Load{
		public function __construct(){
			spl_autoload_register("Q\Load::autoloadModel");
		}
		public static function autoloadModel($ModelName = ""){
			if(file_exists(AppPath."/".$ModelName.".php")){
				include AppPath."/".$ModelName.".php";
			}
			else{
				
			}
		}
		public function controller($ControllerName = false,$Method = "index"){
			if($ControllerName){
				if(is_array($ControllerName)){
					$Controller = $Controller;
				}
				else{
					$Controller = explode("/",$Controller);
				}
				
			}
		}
		public function model($ModelName = ""){
			$ModelName = "Models\\$ModelName"."Model";
			$sp = DIRECTORY_SEPARATOR;
			$ModelName = strtr($ModelName, "\\", $sp);
			if(class_exists($ModelName)){
				return new $ModelName();
			}
		}
		public function view($View = false,$Data = array()){
			global $q;
			extract($Data);
			if(file_exists(AppPath."/Views/".$View."View".".php")){
				include AppPath."/Views/".$View."View".".php";
			}
		}
	}
?>