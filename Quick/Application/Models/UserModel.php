<?php
	namespace Models;
	use Q\Model;
	class UserModel extends Model{
		public $ErrorCode;
		public $ErrorDetail;
		function newUser($UserName = false, $Password = false, $Email = false){
			if($UserName and $Password and $Email){
				if($this->CheckUserByUserName($UserName)){
					$this->ErrorDetail = "This user already exist.";
					return false;
				}
				else if($this->CheckUserByEmail($Email)){
					$this->ErrorDetail = "This email already exist.";
					return false;
				}
				else{
					$ActivationCode = $this->CreateActivationCode();
					$this->insert("users","UserName,Password,Email,ActivationCode","'$UserName','$Password','$Email','$ActivationCode'");
					if($this->lastInsertId()>0){
						return $this->lastInsertId();
					}
					else{
						$this->ErrorDetail = "Failed User Adding.";
						return false;
					}
				}
			}
			else{
				$this->ErrorDetail = "Username or Password or Email dont valid.";
				return false;
			}
		}
		function checkUserByUserName($UserName = false){
			if($UserName){
				$Control = $this->select("users","UserName='$UserName'");
				if(count($Control)>0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function checkUserByEmail($Email = false){
			if($Email){
				$Control = $this->select("users","Email='$Email'");
				if(count($Control)>0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function createActivationCode($Size = 0){
			$abc = "ABCDEFGHIJKLMNOPRSTUVYZWXQ";
			$numbers = "0123456789";
			$Text = "";
			if($Size == 0){
				$Size = 8; // Default
			}
			for($i=0;$i<=$Size;$i++){
				$Rand1 = rand(0,1);
				if($Rand1 == 0){
					$Text.= $abc[rand(0,strlen($abc)-1)];
				}
				else{
					$Text.= $numbers[rand(0,strlen($numbers)-1)];
				}
			}
			return $Text;
		}
		function registerUserInfo($UserId = false,$SubScript = false,$Value = false){
			if($UserId and $SubScript and $Value){
				if($SubScript == "Email" or $SubScript == "Password"){
					$this->update("users","$SubScript='$Value'","UserId='$UserId'");
				}
				else{
					if(count($this->select("user_info","UserId='$UserId' and SubScript='$SubScript'"))>0){
						$this->update("user_info","Value='$Value'","UserId='$UserId' and SubScript='$SubScript'");
					}
					else{
						$this->insert("user_info","UserId,SubScript,Value","'$UserId','$SubScript','$Value'");
					}
				}
				return true;
			}
			else{
				return false;
			}
		}
		function updateUser($UserId = false, $SubScript = false, $Value = false){
			if($UserId and $SubScript and $Value){
				$this->RegisterUserInfo($UserId,$SubScript,$Value);
			}
		}
		function getUserInfo($UserId, $SubScript){
			if($UserId and $SubScript){
				if($SubScript == "UserName" or $SubScript == "Email" or $SubScript == "ActivationCode"){
					$Info = $this->select("users","UserId='$UserId'","$SubScript");
					if(count($Info)>0){
						return $Info[0][$SubScript];
					}
					else{
						return "";
					}
				}
				else{
					$Info = $this->select("user_info","UserId='$UserId' and SubScript='$SubScript'");
					if(count($Info)>0){
						return $Info[0]["Value"];
					}
					else{
						return "";
					}
				}
			}
			return false;
		}
		function isActivated($UyeId = false){
			if($UyeId){
				$Info = $this->select("users","UyeId='$UyeId'","IsActivated");
				if(count($Info)>0){
					return $Info[0]["IsActivated"];
				}else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function isBanned($UyeId = false){
			if($UyeId){
				$Info = $this->select("users","UyeId='$UyeId'","IsBanned");
				if(count($Info)>0){
					return $Info[0]["IsBanned"];
				}else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function getActivationCode($UyeId = false){
			if($UyeId){
				$Info = $this->select("users","UyeId='$UyeId'","ActivationCode");
				if(count($Info)>0){
					return $Info[0]["ActivationCode"];
				}else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function getUser($String = ""){
			if(is_string($String)){
				
			}
			else if(is_numeric($String)){
				
			}
			else if(is_array($String)){
				
			}
		}
		function postActivationCode($UserId = false,$From = "", $Title = false, $LeftText = false, $RightText = false){
			if($UserId){
				$ActivationCode = $this->GetActivationCode($UserId);
				$Email = $this->GetUserInfo($UserId,"Email");
				if(!$From){
					$From = "";
				}
				if($ActivationCode and $Email){
					$Mail = new PHPMailer();
					$Mail->IsSMTP();
					$Mail->SMTPDebug = 0;
					$Mail->DebugOutput = "html";
					$Mail->host = get::Config("Email","SmtpHost");
					$Mail->Port = get::Config("Email","SmtpPort");
					$Mail->SMTPSecure = get::Config("Email","SmtpSecure");
					$Mail->SMTPAuth = true;
					$Mail->Username = get::Config("Email","SmtpUsername");
					$Mail->Password = get::Config("Email","SmtpPassword");
					$Mail->SetFrom($From,$From);
					$Mail->AddAddress($Email,$this->GetUserInfo($UserId,"Username"));
					$Mail->Subject = "Activation Code";
					$Mail->msgHTML($LeftText.$ActivationCode.$RightText);
					if($Mail->send()){
						return true;
					}
					else{
						$this->ErrorCode = 4;
						$this->ErrorDetail = $Mail->ErrorInfo;
						return false;
					}
				}
			}
		}
		function activateUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("users","IsActivated='1'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function deActivateUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("users","IsActivated='0'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function banUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("users","IsBanned='1'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function unBanUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				if($UserId == ""){
					$this->update("users","IsBanned='0'","UserId='$UserId'");
				}
			}
			else{
				return false;
			}
		}
		function deleteUser($UserId = false){
			if($UserId and is_numeric($UserId)){
				$UserId = $this->Uselib->Clean($UserId);
				$this->delete("users","UserId='$UserId'");
				$this->delete("user_info","UserId='$UserId'");
			}
		}
		function freezeUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				$this->update("users","IsFreeze='1'","UserId='$UserId'");
			}
		}
		function unFreezeUser($UserId = false){
			if($UserId){
				$UserId = $this->Uselib->Clean($UserId);
				$this->update("users","IsFreeze='0'","UserId='$UserId'");
			}
		}
	}
?>