<?php
	namespace Models;
	use Q\Model;
	class CommentModel extends Model{
		function newComment($PostId = false, $UserId = false, $Comment = "", $SubCommentId = 0, $OtherUserInfo = ""){
			if($PostId and !empty($Comment)){
				if(!is_numeric($PostId)){
					return false;
				}
				$Post = count($this->select("posts","PostId='$PostId'"));
				if($Post>0){
					if($SubCommentId != 0 and $SubCommentId != "" and is_numeric($SubCommentId)){
						$SubComment = count($this->select("comments","CommentId='$SubCommentId' and PostId='$PostId'"));
						if($SubComment<=0){
							return false;
						}
					}
					if($UserId){
						$this->insert("comments",false,"'','$PostId','$UserId','$Comment','$SubCommentId','$OtherUserInfo'");
					}
					else{
						if(!empty($OtherUserInfo)){
							$this->insert("comments",false,"'','$PostId','0','$Comment','$SubCommentId','$OtherUserInfo'");
						}
						else{
							return false;
						}
					}
				}
			}
			return false;
		}
		function getComments($PostId = false){
			$PostId = intval($PostId);
			if($PostId>0){
				return $this->select("comments","PostId='$PostId'");
			}
			else{
				return array();
			}
		}
		function deleteComment($CommentId = false){
			if($CommentId and is_numeric($CommentId)){
				$this->delete("comments","CommentId='$CommentId'");
			}
		}
	}
?>