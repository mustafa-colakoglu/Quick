<?php
	namespace Models;
	use Q\Model;
	class CategoryModel extends Model{
		function newCategory($CategoryName = false, $Sub = 0){
			if(is_string($CategoryName)){
				$CategoryName = $this->Uselib->formDataFix($CategoryName);
				if(!is_numeric($Sub)){
					$Sub = 0;
				}
				$this->insert("categories",false,"'','$CategoryName','$Sub'");
			}
			return $this->lastInsertId();
		}
		function updateCategory($CategoryId = false, $SubString = false, $Value = ""){
			if($CategoryId and is_numeric($CategoryId) and is_string($SubString)){
				if($SubString == "CategoryName" or $SubString == "Sub"){
					$Value = $this->Uselib->formDataFix($Value);
					$this->update("categories","$SubString='$Value'","CategoryId='$CategoryId'");
				}
			}
		}
		function getCategories($Sub = "*"){
			if($Sub == "*"){
				return $this->select("categories");
			}
			return $this->select("categories","Sub='$Sub'");
		}
		function deleteCategory($CategoryId = false){
			if($CategoryId and is_numeric($CategoryId)){
				$this->delete("categories","CategoryId='$CategoryId'");
				$this->delete("categories","Sub='$CategoryId'");
			}
		}
	}
?>