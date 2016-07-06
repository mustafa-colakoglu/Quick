<?php
	use MS\MSModel;
	class Journal{
		public $AutoSet = true;
		public $MaxTime = false;
		public $AllTags;
		public $Tags = array();
		function run(){
			$Database = new MSModel();
			if(!$this->MaxTime){
				$this->MaxTime = 24*60*60;
				$MaxTime = time() - $this->MaxTime;
			}
			else{
				$MaxTime = time()-$this->MaxTime;
			}
			$this->AllTags = $Database->select("high_post_tags","Time>=$MaxTime");
		}
		function GetTags(){
			if($this->AutoSet){
				return $this->SetTags();
			}
			return $this->AllTags;
		}
		function SetTags(){
			foreach($this->AllTags as $Tag){
				if($this->inArray($Tag["Tag"],$this->Tags)>=0){
					$this->Tags[$this->inArray($Tag["Tag"],$this->Tags)][1]++;
				}
				else{
					$array = array($Tag["Tag"],1);
					array_push($this->Tags,$array);
				}
			}
			$this->Tags = $this->QuickSort($this->Tags);
			return $this->Tags;
		}
		function QuickSort($Dizi){
			if(count($Dizi) <= 1){
				return $Dizi;
			}
			else{
				$pivot = $Dizi[0][1];
				$left = array();
				$right = array();
				for($i=1;$i<count($Dizi);$i++){
					if($Dizi[$i][1]>$pivot){
						$left[] = $Dizi[$i];
					}
					else{
						$right[] = $Dizi[$i];
					}
				}
				return array_merge($this->QuickSort($left),array($Dizi[0]),$this->QuickSort($right));
			}
		}
		function inArray($Tag,$Array){
			for($i=0;$i<count($Array);$i++){
				if($Array[$i][0] == $Tag){
					return $i;
				}
			}
			return -1;
		}
	}
?>