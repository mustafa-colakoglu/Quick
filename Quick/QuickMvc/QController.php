<?php
	namespace Q;
	use Q\Load;
	class Controller{
		public $Load;
		public function __construct(){
			$this->Load = new Load();
		}
	}
?>