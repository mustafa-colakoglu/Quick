<?php
	use Q\Model;
	use Q\Load;
	class thm extends Model{
		public $Load;
		public $Q;
		function __construct(){
			$this->Load = new Load;
			$Q = array();
			$Q["User"] = $this->Load->model("User");
			$Q["Post"] = $this->Load->model("Post");
			$Q["Comment"] = $this->Load->model("Comment");
			$Q["Category"] = $this->Load->model("Category");
			$Q["IO"] = $this->Load->model("IO");
			$this->Q = $Q;
		}
		function Comment($Comments = array()){
			if(is_array($Comments)){
				$array = array();
				$array["Q"] = $this->Q;
				$array["Comments"] = $Comments;
				$this->Load->view("Comment",$array);
			}
		}
		function Post(){}
	}
?>