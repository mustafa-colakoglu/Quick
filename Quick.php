<?php
	class Quick{
		public $Settings;
		function __construct(){
			spl_autoload_register("Quick::AutoLoad");
		}
		public static function autoLoad($ClassName = ""){
			$ClassMap = self::ClassMap();
			if(isset($ClassMap[$ClassName])){
				include __DIR__."/".$ClassMap[$ClassName];
			}
		}
		public function set($Settings = array()){
			$this->Settings = $Settings;
		}
		public function start(){
			$QuickMvc = new QuickMvc($this->Settings);
		}
		public static function classMap(){
			return array(
				"QuickMvc" => "Quick/QuickMvc.php"
			);
		}
	}
	
	$Quick = new Quick();
	$Sets = array(
		"Database" => array(
			"type" => "mysql",
			"server" => "localhost",
			"port" => false,
			"username" => "root",
			"password" => "",
			"dbname" => "quick"
		)
	);
	$Quick->set($Sets);
	$Quick->start();
?>