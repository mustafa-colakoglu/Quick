<?php
	class Quick{
		public $Settings;
		public $QuickMvc;
		public $Post;
		public $User;
		public $Category;
		public $Comment;
		public $IO;
		public $thm;
		function __construct(){
			spl_autoload_register("Quick::autoload");
		}
		public static function autoload($ClassName = ""){
			$ClassMap = self::ClassMap();
			if(isset($ClassMap[$ClassName])){
				include __DIR__."/".$ClassMap[$ClassName];
			}
		}
		public function start(){
			$this->QuickMvc = new QuickMvc();
			$this->thm = $this->QuickMvc->thm;
			$this->Load = $this->QuickMvc->Load;
			$Models = $this->QuickMvc->Models;
			$this->Post = $Models[0];
			$this->User = $Models[1];
			$this->Category = $Models[2];
			$this->Comment = $Models[3];
			$this->IO = $Models[4];
		}
		function uploadFile($Dest = false,$Target = false){
			return $this->QuickMvc->uploadFile($Dest, $Target);
		}
		function getFile($FileName = ""){
			$this->QuickMvc->getFile($FileName);
		}
		function getFileBase64($FileName = ""){
			return $this->QuickMvc->getFileBase64($FileName);
		}
		public static function classMap(){
			return array(
				"QuickMvc" => "Quick/QuickMvc.php"
			);
		}
	}
?>