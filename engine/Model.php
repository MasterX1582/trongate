<?php
class Model {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;
    private $debug = false;
    private $query_caveat = 'The query shown above is how the query would look <i>before</i> binding.';

    public function __construct() {

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error; die();
        }

    }

    private function get_param_type($value) {

        switch(true){
            case is_int($value):
            $type = PDO::PARAM_INT;
            break;
        case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
        case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
        default:
            $type = PDO::PARAM_STR;
        }

        return $type;       
    }

    //execute the prepared statement
    public function execute(){
        return $this->stmt->execute();
    }

    private function get_table_from_url() {
        $segments = SEGMENTS;

        if (isset($segments[1])) {
            $target_tbl = $segments[1];
        } else {
            $target_tbl = '';
        }

        $target_tbl = $this->correct_tablename($target_tbl);

        return $target_tbl;
    }

    private function correct_tablename($target_tbl) {
        $bits = explode('-', $target_tbl);
        $num_bits = count($bits);
        if ($num_bits>1) {
            $target_tbl = $bits[$num_bits-1];
        }

        return $target_tbl;
    }

    private function add_limit_offset($sql, $limit, $offset) {

        if ((is_numeric($limit)) && (is_numeric($offset))) {
            $limit_results = true;
            $sql.= " LIMIT $offset, $limit";
        }

        return $sql;

    }

    public function get($order_by=NULL, $target_tbl=NULL, $limit=NULL, $offset=NULL) {

        $limit_results = false;

        if (!isset($order_by)) {
            $order_by = 'id';
        }

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl order by $order_by";

        if ((isset($limit)) && (isset($offset))) {
            $sql = $this->add_limit_offset($sql, $limit, $offset);
        }

        if ($this->debug == true) {

            if ($limit_results == true) {
                $params['limit'] = $limit;
                $params['offset'] = $offset;
            } else {
                $params = [];
            }

            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);

        if ($limit_results == true) {
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        $query = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $query;

    }

    public function get_where_custom($column, $value, $operator=NULL, $order_by=NULL, $target_tbl=NULL, $limit=NULL, $offset=NULL) {

        $limit_results = false;

        if (!isset($operator)) {
            $operator = '=';
        }

        if (!isset($order_by)) {
            $order_by = 'id';
        }

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl where $column $operator :value order by $order_by";

        if ((isset($limit)) && (isset($offset))) {
            $sql = $this->add_limit_offset($sql, $limit, $offset);
        }

        if ($this->debug == true) {

            $operator = strtoupper($operator);
            if (($operator == 'LIKE') || ($operator == 'NOT LIKE')) {
                $value = '%'.$value.'%';
            }

            if ($limit_results == true) {
                $params['limit'] = $limit;
                $params['offset'] = $offset;
            }

            $params['value'] = $value;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":value", $value, PDO::PARAM_STR);

        if ($limit_results == true) {
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        $query = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $query;

    }

    //fetch a single record
    public function get_where($id, $target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl where id = :id";

        if ($this->debug == true) {
            $params['id'] = $id;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();
        $query = $stmt->fetch(PDO::FETCH_OBJ);
        return $query;

    }

    //fetch a single record (alternative version)
    public function get_one_where($column, $value, $target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl where $column = :value";

        if ($this->debug == true) {
            $params['value'] = $value;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":value", $value, PDO::PARAM_INT);

        $stmt->execute();
        $query = $stmt->fetch(PDO::FETCH_OBJ);
        return $query;
        
    }

    public function count_where($column, $value, $operator=NULL, $order_by=NULL, $target_tbl=NULL, $limit=NULL, $offset=NULL) {
        $query = $this->get_where_custom($column, $value, $operator, $order_by, $target_tbl, $limit, $offset);
        $num_rows = count($query);
        return $num_rows;
    }

    public function count($target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT COUNT(id) as total FROM $target_tbl";

        if ($this->debug == true) {
            $params = [];
            $query_to_execute = $this->show_query($sql, $params);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;

    }

    public function get_max($target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT MAX(id) AS max_id FROM $target_tbl";

        if ($this->debug == true) {
            $params = [];
            $query_to_execute = $this->show_query($sql, $params);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_id = $result['max_id'];
        return $max_id;
    }

    //get result set as array of objects
    public function resultSet() {
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function show_query($query, $params, $caveat=NULL) {
        $keys = array();
        $values = $params;
        $named_params = true;

        # build a regular expression for each parameter
        foreach ($params as $key => $value) {

            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
                $named_params = false;
            }

            if (is_string($value))
                $values[$key] = "'" . $value . "'";

            if (is_array($value))
                $values[$key] = "'" . implode("','", $value) . "'";

            if (is_null($value))
                $values[$key] = 'NULL';
        }

        if ($named_params == true) {
            $query = preg_replace($keys, $values, $query);
        } else {

            $query = $query.' ';
            $bits = explode(' ? ', $query);

            $query = '';
            for ($i=0; $i < count($bits); $i++) { 
                $query.= $bits[$i];

                if (isset($values[$i])) {
                    $query.= ' '.$values[$i].' ';
                }

            }

        }

        if (!isset($caveat)) {
            $caveat_info = '';
        } else {

            $caveat_info = '<br><hr><div style="font-size: 0.8em;"><b>PLEASE NOTE:</b> '.$caveat;
            $caveat_info.= ' PDO currently has no means of displaying previous query executed.</div>';
        }

        echo '<div class="tg-rprt"><b>QUERY TO BE EXECUTED:</b><br><br>  -> ';
        echo $query.$caveat_info.'</div>';
        ?>

<style>
.tg-rprt {
color: #383623;
background-color: #efe79e;
font-family: "Lucida Console", Monaco, monospace;
padding: 1em;
border: 1px #383623 solid;
clear: both !important;
margin: 1em 0;
}    
</style>

    <?php
    }

    public function insert($data, $target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = 'INSERT INTO '.$target_tbl.' (';
        $sql.= implode(", ", array_keys($data)).')';
        $sql.= ' VALUES (';

        foreach ($data as $key => $value) {
            $sql.=':'.$key.', ';
        }

        $sql = rtrim($sql, ', ');
        $sql.=')';

        if ($this->debug == true) {
            $params = $data;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($data);

    }

    public function update($update_id, $data, $target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "UPDATE `$target_tbl` SET ";

        foreach ($data as $key => $value) {
            $sql.= "`$key` = :$key, ";
        }

        $sql = rtrim($sql, ', ');
        $sql.= " WHERE `$target_tbl`.`id` = :id";

        $data['id'] = $update_id;

        if ($this->debug == true) {
            $params = $data;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($data);

    }

    public function delete($id, $target_tbl=NULL) {

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "DELETE from `$target_tbl` WHERE id = :id ";
        $data['id'] = $id;

        if ($this->debug == true) {
            $params = $data;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($data);

    }

    public function query($sql) {

        //WARNING: very high risk of SQL injection - use with caution!

        if ($this->debug == true) {
            $params = [];
            $query_to_execute = $this->show_query($sql, $params);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $query = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $query;
    }

    public function query_bind($sql, $data) {

        if ($this->debug == true) {
            $params = $data;
            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat); 
        }

        $stmt = $this->dbh->prepare($sql);

        if (isset($data[0])) {
            $stmt->execute($data);
        } else {
            foreach ($data as $key => $value) {
                $type = $this->get_param_type($value);
                $stmt->bindValue(":$key", $value, $type);
            }

            $stmt->execute();
        }

        $query = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $query;

    }

    public function insert_batch($table, array $records) {

        //WARNING:  Never let your website visitors invoke this method!
        $fields = array_keys($records[0]);
        $placeHolders = substr(str_repeat(',?', count($fields)), 1);
        $values = [];
        foreach ($records as $record) {
            array_push($values, ...array_values($record));
        }

        $sql = 'INSERT INTO ' . $table . ' (';
        $sql .= implode(',', $fields);
        $sql .= ') VALUES (';
        $sql .= implode('),(', array_fill(0, count($records), $placeHolders));
        $sql .= ')';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);

    }

    public function exec($sql) {
        if (ENV == 'dev') {
            //this gets used on auto module table setups
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
        } else {
            echo 'Feature disabled, since not on \'dev\' mode.';
        }
    }

}