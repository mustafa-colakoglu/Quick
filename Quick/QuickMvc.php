<?php
	class QuickMvc{
		public $Settings;
		public $Post;
		public $User;
		public $Category;
		public $Comment;
		public $AppPath = "Application";
		public function __construct($Settings = array()){
			$this->Settings = $Settings;
			spl_autoload_register("QuickMvc::autoloadFramework");
			$Load = new Q\Load();
		}
		public static function autoloadFramework($ClassName = ""){
			$ClassMap = self::ClassMap();
			if(isset($ClassMap[$ClassName])){
				include __DIR__."/".$ClassMap[$ClassName];
			}
			else if(file_exists($this->AppPath."/Libraries/".$ClassName.".php")){
				include $this->AppPath."/Libraries/".$ClassName.".php";
			}
			else{
				
			}
		}
		public static function classMap(){
			return array(
				"Q\Controller" => "QuickMvc/Controller.php",
				"Q\Load" => "QuickMvc/Load.php",
				"Q\Model" => "QuickMvc/Model.php",
			);
		}
	}
?>