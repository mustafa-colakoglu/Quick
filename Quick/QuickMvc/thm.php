<?php
	use Q\Model;
	use Q\Load;
	class thm extends Model{
		public $Load;
		function __construct(){
			$this->Load = new Load;
		}
		function Comment($Comments = array()){
			if(is_array($Comments)){
				$array = array();
				$array["Comments"] = $Comments;
				$array["QUser"] = $this->Load->model("User");
				$array["QPost"] = $this->Load->model("Post");
				$this->Load->view("Comment",$array);
			}
		}
		function Post(){}
	}
?>