<?php

class Database {
    private $db_host = "localhost";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "land";

    private $mysqli = null;
    private $result = array();
    private $conn = false;

    // Constructor to establish the database connection
    public function __construct() {
        if (!$this->conn) {
            $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            $this->conn = true;
            if ($this->mysqli->connect_error) {
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }
        } else {
            return true; 
        }
    }

    // Function to execute SQL queries
    public function query($sql) {
        return $this->mysqli->query($sql);
    }

    // Function to escape strings to prevent SQL injection
    public function escapeString($str) {
        return $this->mysqli->real_escape_string($str);
    }

    // Function to insert data into the database
    // public function insert($table, $params = array()) {
    //     if ($this->tableExists($table)) {
    //         $table_columns = implode(', ', array_keys($params));
    //         $table_values = implode("', '", array_map([$this->mysqli, 'real_escape_string'], $params));

    //         $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";
    //         if ($this->mysqli->query($sql)) {
    //             array_push($this->result, $this->mysqli->insert_id);
    //             return true;
    //         } else {
    //             array_push($this->result, $this->mysqli->error);
    //             return false;
    //         }
    //     } else {
    //         return false;
    //     }
    // }

    public function insert($table, $params = array()) {
        if ($this->tableExists($table)) {
            // Escape column names
            $table_columns = implode(', ', array_keys($params));
    
            // Escape and quote values
            $table_values = "'" . implode("', '", array_map([$this->mysqli, 'real_escape_string'], $params)) . "'";
    
            $sql = "INSERT INTO $table ($table_columns) VALUES ($table_values)";
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->insert_id);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }


    // Function to update a row in the database
    public function update($table, $params = array(), $where = null) {
        if ($this->tableExists($table)) {
            $args = array();
            foreach ($params as $key => $value) {
                $args[] = "$key = '" . $this->mysqli->real_escape_string($value) . "'";
            }
            $sql = "UPDATE $table SET " . implode(', ', $args);
            if ($where != null) {
                $sql .= " WHERE $where";
            }

            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }

    // Function to delete a table or row from the database
    public function delete($table, $where = null) {
        if ($this->tableExists($table)) {
            $sql = "DELETE FROM $table";
            if ($where != null) {
                $sql .= " WHERE $where";
            }
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }

    // Function to select data from the database
    public function select($table, $rows = "*", $join = null, $where = null, $order = null, $limit = null) {
        if ($this->tableExists($table)) {
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
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $start = ($page - 1) * $limit;
                $sql .= " LIMIT $start, $limit";
            }

            $query = $this->mysqli->query($sql);

            if ($query) {
                $this->result = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        } else {
            return false;
        }
    }

    // Function for pagination
    public function pagination($table, $join = null, $where = null, $limit = null) {
        if ($this->tableExists($table)) {
            if ($limit != null) {
                $sql = "SELECT COUNT(*) FROM $table";
                if ($join != null) {
                    $sql .= " JOIN $join";
                }
                if ($where != null) {
                    $sql .= " WHERE $where";
                }

                $query = $this->mysqli->query($sql);

                $total_record = $query->fetch_array();
                $total_record = $total_record[0];

                $total_page = ceil($total_record / $limit);

                $url = basename($_SERVER['PHP_SELF']);

                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }

                $output = "<ul class='pagination'>";

                if ($page > 1) {
                    $output .= "<li><a href='$url?page=" . ($page - 1) . "'>Prev</a></li>";
                }
                if ($total_record > $limit) {
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i == $page) {
                            $cls = "class='active'";
                        } else {
                            $cls = "";
                        }
                        $output .= "<li><a $cls href='$url?page=$i'>$i</a></li>";
                    }
                }
                if ($total_page > $page) {
                    $output .= "<li><a href='$url?page=" . ($page + 1) . "'>Next</a></li>";
                }

                $output .= "</ul>";
                // echo $output
                return $output;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Function to execute custom SQL queries
    public function sql($sql) {
        $query = $this->mysqli->query($sql);

        if ($query) {
            $this->result = $query->fetch_all(MYSQLI_ASSOC);
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }
    }

    // Function to check if a table exists in the database
    private function tableExists($table) {
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if ($tableInDb) {
            if ($tableInDb->num_rows == 1) {
                return true;
            } else {
                array_push($this->result, $table . " does not exist in this database");
                return false;
            }
        }
    }

    // Function to get the result of the last operation
    public function getResult() {
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    // Destructor to close the database connection
    public function __destruct() {
        if ($this->conn) {
            if ($this->mysqli->close()) {
                $this->conn = false;
                return true;
            }
        } else {
            return false;
        }
    }
}
?>