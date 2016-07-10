<?php
	namespace Models;
	use Q\Model;
	class PostModel extends Model{
		function newPost($PostUserId = 1, $PostTitle = "", $Post = "", $PostDate = "",$CategoryId = 0){
			$PostTime = time();
			if($PostDate == ""){
				$PostDate = date("d.m.Y");
			}
			$Link = $this->convertLink($PostTitle);
			$this->insert("posts","PostUserId,Link,PostTitle,Post,PostDate,PostTime,CategoryId","'$PostUserId','$Link','$PostTitle','$Post','$PostDate','$PostTime','$CategoryId'");
			$LastId = $this->lastInsertId();
			$Link = $Link."-".$LastId;
			$this->update("posts","Link='$Link'","PostId='$LastId'");
			return $LastId;
		}
		function convertLink($Title = ""){
			if(is_string($Title)){
				$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
				$make = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
				$perma = strtolower(str_replace($find, $make, $Title));
				$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
				$perma = trim(preg_replace('/\s+/',' ', $perma));
				$perma = str_replace(' ', '-', $perma);
				return $perma;
			}
		}
		function updatePost($PostId = false,$Updates = false){
			if($PostId){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId != ""){
					$UpdatesNew = "";
					$UpdatesAdd = array();
					foreach($Updates as $Sub => $Value){
						if($Sub == "PostUserId" || $Sub == "PostTitle" || $Sub == "Post" || $Sub == "PostDate" || $Sub == "PostTime"){
							$UpdatesNew.=$Sub."='".$Value."',";
						}
						else{
							$UpdatesAdd[$Sub] = $Value;
						}
					}
					$UpdatesNew = trim($UpdatesNew,",");
					$this->update("posts",$UpdatesNew,"PostId='$PostId'");
					foreach($UpdatesAdd as $Sub => $Value){
						$this->RegisterPostInfo($PostId,$Sub,$Value);
					}
				}
			}
			return false;
		}
		function registerPostInfo($PostId = false,$SubScript = false,$Value = ""){
			if($PostId and $SubScript){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId){
					$Control = $this->select("post_info","PostId='$PostId' and SubScript='$SubScript'");
					if(count($Control)<0){
						$this->insert("post_info",false,"'','$PostId','$SubScript','$Value'");
					}
					else{
						$this->update("post_info","Value='$Value'","PostId='$PostId' and SubScript='$SubScript'");
					}
				}
			}
		}
		function addPostTag($PostId = false, $Tags = false){
			if($PostId and $Tags){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId){
					if(is_string($Tags)){
						$Tags = $this->Uselib->formDataFix($Tags);
						$DoControl = $this->select("post_tags","PostId='$PostId' and Tag='$Tags'");
						if(count($DoControl)>0){}
						else{
							$Time = time();
							$this->insert("post_tags",false,"'','$PostId','$Tags','$Time'");
						}
					}
					else if(is_array($Tags)){
						for($i=0;$i<count($Tags);$i++){
							$Tag = $this->Uselib->formDataFix($Tags[$i]);
							$DoControl = $this->select("post_tags","PostId='$PostId' and Tag='$Tag'");
							if(count($DoControl)>0){}
							else{
								$Time = time();
								$this->insert("post_tags",false,"'','$PostId','$Tag','$Time'");
							}
						}
					}
					else{
						return false;
					}
				}
			}
		}
		function uploadPostImage($PostId = false,$Files = false,$ImageType = 0,SetImage $Settings){
			if($PostId and $Files){
				$PostId = $this->Uselib->Clean($PostId);
				if($PostId){
					if(isset($_FILES[$Files])){
						$ImageNames = array();
						foreach($_FILES as $File){
							if($File["error"] == 0){
								$Image = $File;
								if($Image["type"] == "image/jpeg" or $Image["type"] == "image/jpg" or $Image["type"] == "image/pjpeg"){
									$Uzanti = ".jpg";
								}
								else if($Image["type"] == "image/png"){
									$Uzanti = ".png";
								}
								else{
									return false;
								}
								$FileName = $this->CreateFileName().$Uzanti;
								$Copy = copy($File["tmp_name"],APPLICATION_PATH."/Front/images/".$FileName);
								if($Copy){
									array_push($ImageNames, $FileName);
									if($Settings){
										$Settings->SaveImage($FileName.$Uzanti);
									}
									$this->insert("post_images",false,"'','$PostId','$FileName','$ImageType'");
								}
								else{
									$this->ErrorCode = 7;
									$this->Error = "This image cant loaded.[ ".$File["name"]." ]";
								}
							}
						}
						return $ImageNames;
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		function createFileName(){
			$FileName = rand(100000,999999);
			if(file_exists(APPLICATION_PATH."/Front/images/".$FileName.".png") or file_exists(APPLICATION_PATH."/Front/images/".$FileName.".jpg")){
				return $this->CreateFileName();
			}
			else{
				return $FileName;
			}
		}
		function getPost($PostId = false){
			if($PostId){
				return $this->GetPosts(array("PostId"=>array($PostId)));
			}
			return false;
		}
		function getPosts($Features = array(),$Sort = array("By" => "PostId","Sort" => "DESC")){
			/*
				Example array: $Features
				array(
					"PostId" => array(),
					"Like" => array(),
					"Tags" => array(),
					"UserId" => array(),
					"CategoryId" => array(),
					"Pagination" => array(
						"Limit" => 10, #example
						"Page" => 3 #example
					)
				);
			*/
			if(isset($Features["PostId"])){
				$PostId = $this->CleanPostId($Features["PostId"]);
				for($i=0;$i<count($PostId);$i++){
					$PostId[$i] = "posts.PostId='".$PostId[$i]."'";
				}
				$PostIdImplode = "".implode(" OR ",$PostId)."";
				if($PostIdImplode == ""){
					$PostIdImplode = "posts.PostId!='0'"; // For All Posts
				}
			}
			else{
				$PostIdImplode = "posts.PostId!='0'";
			}
			$LikeImplode = " posts.PostTitle LIKE '%%'";
			if(isset($Features["Like"])){
				$Like = $Features["Like"];
				for($i=0;$i<count($Like);$i++){
					$Like[$i] = "(CONCAT(posts.PostTitle,posts.Post) LIKE '".$Like[$i]."')";
				}
				$LikeImplode = "".implode(" OR ",$Like)."";
			}
			$TagImplode = "";
			if(isset($Features["Tags"])){
				$Tags = $Features["Tags"];
				for($i=0;$i<count($Tags);$i++){
					$Tags[$i] = "post_tags.Tag='".$Tags[$i]."'";
				}
				$TagImplode = "".implode(" OR ",$Tags)."";
			}
			$UserIdImplode = "posts.PostUserId!='-1'";
			if(isset($Features["UserId"])){
				$UserIds = $Features["UserId"];
				for($i=0;$i<count($UserIds);$i++){
					$UserIds[$i] = "posts.PostUserId='".$UserIds[$i]."'";
				}
				$UserIdImplode = implode(" OR ",$UserIds);
			}
			$CategoryImplode = "posts.CategoryId!='-1'";
			if(isset($Features["CategoryId"])){
				$CategoryIds = $Features["CategoryId"];
				for($i=0;$i<count($CategoryIds);$i++){
					$CategoryIds[$i] = "posts.CategoryId='".$CategoryIds[$i]."'";
				}
				$CategoryImplode = implode(" OR ",$CategoryIds);
			}
			$Limit = "";
			if(isset($Features["Pagination"])){
				$Pagination = $Features["Pagination"];
				$Start = $Pagination["Page"]*$Pagination["Limit"];
				$Finish = $Pagination["Limit"];
				$Limit = " LIMIT ".$Start.",".$Finish;
			}
			if(!isset($Sort["By"])){
				$Sort["By"] = "PostId";
			}
			if(!isset($Sort["Sort"])){
				$Sort["Sort"] = "DESC";
			}
			switch($Sort["By"]){
				case "PostId": $SortTable="posts";break;
				case "PostUserId": $SortTable="posts";break;
				case "PostTitle": $SortTable="posts";break;
				case "Post": $SortTable="posts";break;
				case "PostDate": $SortTable="posts";break;
				case "PostTime": $SortTable="posts";break;
				case "Tag": $SortTable="post_tags";break;
				default:$SortTable="posts";break;
			}
			if(!is_array($Features) and is_numeric($Features)){
				$posts = $this->select("posts","","","LIMIT ".$Features);
			}
			else if($TagImplode == "" or empty($TagImplode)){
				$posts = $this->select(
					"posts",
					$LikeImplode." AND ".$PostIdImplode." AND ".$CategoryImplode." AND ".$UserIdImplode,
					"posts.PostId,posts.PostUserId,posts.PostTitle,posts.Post,posts.PostDate,posts.PostTime",
					"ORDER BY ".$SortTable.".".$Sort["By"]." ".$Sort["Sort"].$Limit
				);
			}
			else{
				$posts = $this->select(
					"posts",
					"",
					"posts.PostId,posts.PostUserId,posts.PostTitle,posts.Post,posts.PostDate,posts.PostTime,post_tags.TagId,post_tags.PostId,post_tags.Tag",
					"INNER JOIN post_tags ON posts.PostId=post_tags.PostId AND ".$TagImplode." AND ".$LikeImplode." AND ".$PostIdImplode." AND ".$CategoryImplode." AND ".$UserIdImplode." GROUP BY post_tags.PostId ORDER BY ".$SortTable.".".$Sort["By"]." ".$Sort["Sort"].$Limit
				);
			}
			return $posts;
		}
		function getPostImages($PostId = false){
			if($PostId){
				if(intval($PostId)>0){
					return $this->select("post_images","PostId='$PostId'");
				}
				return array();
			}
			return array();
		}
		function getPostTags($PostId = false){
			if($PostId){
				if(intval($PostId)>0){
					return $this->select("post_tags","PostId='$PostId'");
				}
				return array();
			}
			return array();
		}
		function deletePost($PostId = false){
			if($PostId and is_numeric($PostId)){
				$this->delete("posts","PostId='$PostId'");
				$this->delete("post_tags","PostId='$PostId'");
				$this->delete("post_info","PostId='$PostId'");
				$this->delete("post_images","PostId='$PostId'");
				return true;
			}
			return false;
		}
		function cleanPostId($Id = array()){
			if(!is_array($Id)){
				return $this->Uselib->clean($Id);
			}
			else{
				for($i=0;$i<count($Id);$i++){
					$Id[$i] = $this->CleanPostId($Id[$i]);
				}
				return $Id;
			}
		}
	}
?>