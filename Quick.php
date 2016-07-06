<?php
	class Quick{
		public $Settings;
		public $QuickMvc;
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
			$this->Load = $this->QuickMvc->Load;
			$Models = $this->QuickMvc->Models;
			$this->Post = $Models[0];
			$this->User = $Models[1];
			$this->Category = $Models[2];
			$this->Comment = $Models[3];
			$this->IO = $Models[4];
		}
		public static function classMap(){
			return array(
				"QuickMvc" => "Quick/QuickMvc.php"
			);
		}
	}
?>