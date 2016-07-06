<?php
	namespace Q;
	use Q\Get;
	use Q\Load;
	class QDb extends Load{
		public $Config;
		public $Database;
		function __construct(){
			spl_autoload_register("Q\QDb::AutoloadDriver");
			$this->Config = get::Config("Database");
			if($this->Config["type"] == "mysql"){
				$this->Database = new QDb\QPdo();
				$this->Database->connect($this->Config["server"],$this->Config["username"],$this->Config["password"],$this->Config["dbname"],$this->Config["port"]);
			}
		}
		public static function AutoloadDriver($ClassName){
			$ClassMap = self::ClassMap();
			if(isset($ClassMap[$ClassName])){
				include $ClassMap[$ClassName];
			}
			else{
				$ClassName = ltrim($ClassName, '\\');
				$parts=explode("\\",$ClassName);
				
				$fileName  = '';
				$namespace = '';
					if ($lastNsPos = strrpos($ClassName, '\\')) {
						$namespace = substr($ClassName, 0, $lastNsPos);
						$ClassName = substr($ClassName, $lastNsPos + 1);
						$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
						$fileName  = SystemPath.str_replace($parts[0], "", $fileName) ;
						
					}
					$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $ClassName) . '.php';
					
					if(is_file($fileName))
						require $fileName;
			}
		}
		public static function ClassMap(){
			return array(
				"Q\QDb\QPdo" => SystemPath."QDb/QPdo.php"
			);
		}
		function select($table, $where="", $column="", $other=""){
			return $this->Database->select($table, $where, $column, $other);
		}
		function insert($tablo,$satirlar=false,$degerler){
			return $this->Database->insert($tablo, $satirlar, $degerler);
		}
		function update($tablo,$set,$where=false,$diger=false){
			return $this->Database->update($tablo,$set,$where,$diger);
		}
		function delete($tablo,$where=false){
			return $this->Database->delete($tablo,$where);
		}
		function query($query = false){
			return $this->Database->query($query);
		}
		function exec($query = false){
			return $this->Database->exec($query);
		}
		function lastInsertId(){
			return $this->Database->lastInsertId();
		}
	}
?>