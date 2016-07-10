<?php
	namespace Models;
	use Q\Model;
	class IOModel extends Model{
		/*
		Session Variables : 
			Boolean QLogin
			String QUsername
			String QPassword
		*/
		function control(){
			$Username = "";
			$Password = "";
			if(isset($_SESSION["QUsername"])){
				$Username = $this->clean($_SESSION["QUsername"]);
			}
			if(isset($_SESSION["QPassword"])){
				$Password = $this->clean($_SESSION["QPassword"]);
			}
			$Control = $this->select("users","UserName='$Username' and Password='$Password'");
			if(count($Control) == 1){
				return true;
			}
			return false;
		}
		function login($Username = "",$Password = ""){
			$Username = $this->clean($Username);
			$Password = $this->clean($Password);
			$Control = $this->select("users","UserName='$Username' and Password='$Password'");
			if(count($Control) == 1){
				$_SESSION["QLogin"] = true;
				$_SESSION["Username"] = $Username;
				$_SESSION["Password"] = $Password;
				return true;
			}
			return false;
		}
		function logout(){
			if($this->islogin()){
				$_SESSION["QLogin"] = false;
				unset($_SESSION["Username"]);
				unset($_SESSION["Password"]);
				return true;
			}
			return false;
		}
		function Username(){
			if($this->islogin()){
				return $_SESSION["Username"];
			}
			return false;
		}
		function islogin(){
			if(isset($_SESSION["QLogin"])){
				if($_SESSION["QLogin"]){
					return true;
				}
				return false;
			}
			else{
				return false;
			}
		}
		function clean($string = "",$chars=false){
			if($chars==""){
				$cikar="'".'";/.,*=-+';
			}
			else{
				$cikar=$chars;
			}
			$count=strlen($cikar);
			$temizle=$string;
			for($i=0;$i<$count;$i++){
				$temizle=str_replace(substr($cikar,$i,1),"",$temizle);
			}
			return $temizle;
		}
	}
?>