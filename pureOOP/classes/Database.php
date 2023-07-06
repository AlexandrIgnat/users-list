<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $conn;
    private bool $error = false;
    private $result = null;
    private int $count = 0;

    public function __construct()
    {
       try {
           $this->conn = new \PDO(Config::get('mysql.connection') . ";dbname=" . Config::get('mysql.database') . ";charset=" . Config::get('mysql.charset'), Config::get('mysql.username'), Config::get('mysql.password'));
       } catch (PDOException $exception) {
           die($exception->getMessage());
       }
    }

    /**
     * @return Database|null
     */
    public static function getInstance(): ?Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql, $values = []): Database
    {
        $this->error = false;

        $query = $this->conn->prepare($sql);

        if (!$query->execute($values)) {
            $this->error = true;
        } else {
            $this->result = $query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $query->rowCount();
        }

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function error(): bool
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return PDO
     */
    public function getConn(): PDO
    {
        return $this->conn;
    }

    public function get($table, $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function first() {
        return $this->getResult()[0];
    }

    public function delete($table, $where = [])
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = [])
    {
        $values = '';
        $field = '';

        foreach ($fields as $key => $value) {
            $field .= "{$key},";
            $values .= ":{$key},";
        }

        $field = rtrim($field, ',');
        $values = rtrim($values, ',');

        $sql = "INSERT INTO {$table} ({$field}) VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) {
            return $this;
        }

        return false;
    }

    public function update($table, $id, $fields)
    {
        $set = '';

        foreach ($fields as $key => $value) {
            $set .= "{$key} = :{$key}, ";
        }

        $set = rtrim($set, ', ');

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return $this;
        }

        return false;
    }

    public function action($action, $table, $where = [])
    {
        $parameters = ['=', '>=', '<=', '<', '>'];

        if (count($where) === 3) {

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $parameters)) {
                $values = [];

                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} :value";

                $values[':value'] = $value;
//                if (!empty($and)) {
//                    $andStatement = '';
//                    foreach ($and as $index => $value) {
//
//                        $field = $value[0];
//                        $operator = $value[1];
//                        $value = $value[2];
//
//                        $andStatement .= " AND {$field} {$operator} :{$index}";
//
//                        $values[":{$index}"] = $value[2];
//                     }
//                }
                if(!$this->query($sql, $values)->error()) {
                    return $this;
                }
            }
            
            $this->error = true;
            return $this;
        }

        return false;
    }

}