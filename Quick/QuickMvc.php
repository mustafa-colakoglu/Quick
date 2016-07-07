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
		function uploadFile($Dest = false,$Target = false){
			if(copy($Dest,AppPath."/Uploads/".$Target)){
				return true;
			}
			return false;
		}
		function getFile($FileName = ""){
			if(file_exists(AppPath."/Uploads/".$FileName) and $FileName != ""){
				$FileType = filetype(AppPath."/Uploads/".$FileName);
				header("Content-type: ".$FileType);
				header('Content-Disposition: attachment; filename='.$FileName);
				readfile(AppPath."/Uploads/".$FileName);
			}
			else{
				header("HTTP/1.0 404 Not Found");
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