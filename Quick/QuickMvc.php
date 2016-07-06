<?php
	define("AppPath",__DIR__ . "/Application/");
	define("SystemPath",__DIR__ . "/QuickMvc/");
	class QuickMvc{
		public $Models;
		public $Load;
		public $thm;
		public function __construct(){
			spl_autoload_register("QuickMvc::autoloadFramework");
			$Load = new Q\Load();
			$this->Load = $Load;
			$this->thm = new thm();
			$this->thm->Load = $this->Load;
			$Models = array($Load->model("Post"),$Load->model("User"),$Load->model("Category"),$Load->model("Comment"),$Load->model("IO"));
			$this->Models = $Models;
			return $Models;
		}
		public static function autoloadFramework($ClassName = ""){
			$ClassMap = self::ClassMap();
			if(isset($ClassMap[$ClassName])){
				include __DIR__."/".$ClassMap[$ClassName];
			}
			else if(file_exists(AppPath."/Libraries/".$ClassName.".php")){
				include AppPath."/Libraries/".$ClassName.".php";
			}
			else{
				
			}
		}
		public static function classMap(){
			return array(
				"Q\Controller" => "QuickMvc/QController.php",
				"Q\Load" => "QuickMvc/QLoad.php",
				"Q\Model" => "QuickMvc/QModel.php",
				"Q\QDb" => "QuickMvc/QDb.php",
				"Q\Get" => "QuickMvc/QGet.php",
				"thm" => "QuickMvc/thm.php"
			);
		}
	}
?>