<?php
class Database {
	private $db_host     = "localhost";
	private $db_user     = "root";
	private $db_pass     = "";
	private $db_name     = "crud_test";
	private $mysqli      = "";
	private $show_result = [];
	private $conn        = false;

	public function __construct() {
	 	 if (!$this->conn) {
	 	 	$this->mysqli = new mysqli($this->db_host, $this->db_user,$this->db_pass,$this->db_name);
	 	 	$this->conn = true;

	 	 	if ($this->mysqli->connect_error) {
	 	 		array_push($this->show_result,$this->mysqli->connect_error);
	 	 		return false;
	 	 	}
	 	 }else {
	 	 	 return true;
	 	 }
	 }


// Function to insert into the database
public function insert ($table, $params = []) {
	if ($this->table_exist($table)) {
		$table_columns = implode(', ', array_keys($params));
		$table_value = implode("', '", $params);

		 $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_value')";

		 if ($this->mysqli->query($sql)) {
		 	array_push($this->show_result, $this->mysqli->insert_id);
		 	return true;
		 }else {
		 	 array_push($this->show_result, $this->mysqli->error);
		 	 return false;
		 }
	}else {
		 return false;
	}
}

// Function to update row in database
public function update ($table, $params = [], $where = null) {
	if ($this->table_exist($table)) {
		$args = [];
		foreach ($params as $key => $value) {
			$args[] = "$key = '$value'";
		}

		$sql = "UPDATE $table SET ". implode(', ', $args);
		if ($where != null) {
			$sql .= " WHERE $where";
		}

		if ($this->mysqli->query($sql)) {
			array_push($this->show_result, $this->mysqli->affected_rows);
			return true;
		}else {
			 array_push($this->show_result, $this->mysqli->error);
		}
	}else {
		 return false;
	}
}

// Function to delete table or row(s) from databse 
public function delete ($table, $where = null) {
	if ($this->table_exist($table)) {
		$sql = "DELETE FROM $table";
		if ($where != null) {
			$sql .= " WHERE $where";
		}

		if ($this->mysqli->query($sql)) {
			array_push($this->show_result, $this->mysqli->affected_rows);
			return true;
		}else {
			 array_push($this->show_result, $this->mysqli->error);
			 return false;
		}
	}else {
		return false; 
	}

}

// Function to select from the database 
public function select ($table, $rows= "*",$join = null,$where = null,$order = null, $limit= null) {
	if ($this->table_exist($table)) {
		$sql = "SELECT $rows FROM $table";

		if ($join != null) {
			$sql .= " JOIN $join";
		}
		if ($where != null) {
			$sql .= " WHERE $where";
		}
		if ($order != null) {
			$sql .= " ORDER BY $order";
		}
		if ($limit != null) {
			$sql .= " LIMIT 0,$limit";
		}

		echo $sql;

		$query = $this->mysqli->query($sql);
		if ($query) {
			$this->show_result = $query->fetch_all(MYSQLI_ASSOC);
			return true;
		}else {
			array_push($this->show_result, $this->mysqli->error);
			return false;
		}
	}else {
		 return false;
	}
}

public function sql ($sql) {
	$query = $this->mysqli->query($sql);

	if ($query) {
		$this->show_result = $query->fetch_all(MYSQLI_ASSOC);
		return true;
	}else {
		 array_push($this->show_result, $this->mysqli->error);
		 return false;
	}
}

public function table_exist ($table) {
	$sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
	$table_in_db = $this->mysqli->query($sql);

	if ($table_in_db) {
		if ($table_in_db->num_rows == 1) {
			return true;
		}else {
			 array_push($this->show_result, $table."does not exist in this database");
			 return false;
		}
	}
}

public function get_result(){
	 $val = $this->show_result;
	 $this->show_result = [];
	 return $val;
}

// Close connection 
public function __destruct() {
	if ($this->conn) {
		if ($this->mysqli->close()) {
			$this->conn = false;
			return true;
		}
	}else {
		 return false;
	}
}

// Class close 


}




