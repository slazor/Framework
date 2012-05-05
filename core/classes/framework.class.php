<?php // 2012-05-05
class Framework {

	private $mysqli, $hash1, $hash2;

	function __construct($framework = FALSE) {
		$this->mysqli = $framework['mysqli'];
		$this->hash1 = $framework['hash'][0];
		$this->hash2 = $framework['hash'][1];
	}

	function __destruct() {
		unset($mysqli,$hash1,$hash2);
	}

	public function getStyles($data = NULL) {
		if(is_array($data) && count($data) > 0) {
			$styles = '';
			foreach($data AS $style) { $styles .= '<link href="'.base_path().'application/assets/css/'.$style.'.css" rel="stylesheet" type="text/css" />'."\r\n"; }
			return $styles;
		}
	}

	public function getScripts($data = NULL) {
		if(is_array($data) && count($data) > 0) {
			$scripts = '';
			foreach($data AS $script) { $scripts .= '<script src="'.base_path().'application/assets/script/'.$script.'.js" type="text/javascript"></script>'."\r\n"; }
			return $scripts;
		}
	}

	public function insert($table = FALSE, $record = FALSE) {
		if(empty($table) || empty($record)) return false;

		$cols = array();
		$vals = array();

		foreach($record AS $col => $val) {
			$cols[] = sprintf("`%s`", $col);
			$vals[] = sprintf("'%s'", $this->cleanData(($val)));
		}

		if($this->mysqli->query(sprintf("INSERT INTO `%s`(%s) VALUES(%s)", $table, implode(", ", $cols), implode(", ", $vals)))) {
			return $this->mysqli->insert_id;
		}

		return false;
	}

	public function update($table = FALSE, $record = FALSE, $arguments = FALSE, $limit = 0) {
		if(empty($table) || empty($record)) return FALSE;

		$cols	= array();
		$args	= array();
		$limit	= ((int)$limit > 0) ? 'LIMIT '.$limit : '';

		foreach($record AS $col => $val) {
			$cols[] = sprintf("%s = '%s'", $col, $this->cleanData($val));
		}

		if($arguments) {
			foreach($arguments AS $col => $arg) {
				$args[] = sprintf("%s = '%s'", $col, $this->cleanData($arg));
			}
		}

		if($arguments) {
			$query = sprintf("UPDATE `%s` SET %s WHERE %s %s", $table, implode(", ", $cols), implode(", ", $args), $limit);
		} else {
			$query = sprintf("UPDATE `%s` SET %s %s", $table, implode(", ", $cols), $limit);
		}

		if($this->mysqli->query($query)) {
			return TRUE;
		}

		return FALSE;
	}

	public function query($sql = '', $data = array()) {
		$query	= '';
		if(!empty($data)) {
			$newArr	= array();
			$return	= array();
			$e		= explode('?', $sql);
			$start	= $e[0];

			// Get all parts
			foreach($e AS $key => $string) { if($key > 0) $newArr[] = $string; }
			// Replace parts
			foreach($newArr AS $key => $string) $query .= '"'.$this->cleanData($data[$key]).'"'.$string;

			$query = $start.$query;

		} else {
			$query = $sql;
		}

		if($result = $this->mysqli->query($query)) {
			if($result->num_rows > 1) {
				while($row = $result->fetch_assoc()) {
					$return[] = $row;
				}
			} else {
				while($row = $result->fetch_assoc()) {
					$return = $row;
				}
			}
			$result->close();
		}

		return $return;
	}


	public function encrypt($string) {
		return sha1(md5($this->hash1.base64_encode($this->hash2.$string)).$this->hash1);
	}
	
	public function load_classes($directory) {
		$files = array();
		$results = array();
		$handler = opendir($directory);
		while($file = readdir($handler)) {
			if($file != "." && $file != ".." && strpos($file,'.class.php')) {
				$files[] = $file;
			}
		}
		closedir($handler);
		
		foreach($files AS $file) {
			$results['file'][] = $file;
			$results['name'][] = str_replace('.class.php','',$file);
		}
		
		return $results;
	}

	// PRIVATE FUNCTIONS

	private function cleanData($value) {
		return $this->stripTags($this->mysqli->real_escape_string($value));
	}

	private function stripTags($value) {
		return strip_tags($value);
	}

}
?>