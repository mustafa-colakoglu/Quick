<?php
	namespace Q;
	class Get{
		static function Config($Config = false){
			if($Config){
				if(file_exists(AppPath."/Config/".$Config.".php")){
					return include AppPath."/Config/".$Config.".php";
				}
				else{
					
				}
			}
		}
	}
?>