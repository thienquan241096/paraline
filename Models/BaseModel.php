<?php
require_once './common_const.php';

class BaseModel
{

    private $db_name;
    private $db_username;
    private $db_pass;
    private $db_host;

    protected $conn;
    protected $table_name;
    protected $primary_key;
    protected $key_value;
    protected $query;
    // protected $del_flag = DEL_FALG;

    public function __construct()
    {
        $this->setDbInfo();
        $this->getConnect();
    }

    protected function setDbInfo()
    {
        $this->db_name = DB_NAME;
        $this->db_username = DB_USERNAME;
        $this->db_pass = DB_PASS;
        $this->db_host = DB_HOST;
    }

    protected function getConnect()
    {
        $this->conn = new PDO("mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8", $this->db_username, $this->db_pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function all($del_flag = DEL_FALG)
    {
        $model = new static();
        $model->query = "SELECT * FROM {$model->table_name} WHERE del_flag = $del_flag";
        return $model->get();
    }

    public static function insert($arr)
    {
        $model = new static();
        $model->query = "INSERT INTO {$model->table_name} (";
        foreach ($arr as $key => $value) {
            $model->query .= "$key,";
        }
        $model->query = rtrim($model->query, ',');
        $model->query .= ') VALUES (';

        foreach ($arr as $key => $value) {
            $model->query .= ":$key,";
        }
        $model->query = rtrim($model->query, ',');
        $model->query .= ')';
        $stmt = $model->conn->prepare($model->query);
        $stmt->execute($arr);

        return $model->conn->lastInsertId();
    }

    public static function delete($id, $params)
    {
        unset($params['id']);
        $model = new static();
        $model->query = "UPDATE {$model->table_name} SET ";
        foreach ($params as $key => $value) {
            $model->query .= " $key = :$key, ";
        }
        $model->query = rtrim($model->query, ', ');

        $model->query .= " WHERE id = $id";

        $stmt = $model->conn->prepare($model->query);

        $stmt->execute($params);

        return $id;
    }

    public static function find($id, $del_flag = DEL_FALG)
    {
        $model = new static();

        $model->query = "SELECT * FROM {$model->table_name} WHERE {$model->primary_key} = $id AND del_flag = $del_flag";

        $result = $model->get();

        return empty($result[0]) ? null : $result[0];
    }

    public static function update($id, $params)
    {
        unset($params['id']);
        $model = new static();
        $model->query = "UPDATE {$model->table_name} SET ";
        foreach ($params as $key => $value) {
            $model->query .= " $key = :$key, ";
        }
        $model->query = rtrim($model->query, ', ');

        $model->query .= " WHERE id = $id";

        $stmt = $model->conn->prepare($model->query);

        $stmt->execute($params);

        return $id;
    }

    public function get()
    {
        $stmt = $this->conn->prepare($this->query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        return $stmt->fetchAll();
    }

    public function getOne()
    {
        $stmt = $this->conn->prepare($this->query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        return $stmt->fetch();
    }

    public function findByEmail($email, $del_flag = DEL_FALG)
    {
        $model = new static();
        $model->query = "SELECT * FROM {$model->table_name} WHERE email = '$email' AND del_flag = $del_flag";
        $result = $model->getOne();
        echo '<pre>';
        var_dump($result);
        echo '</pre>';
        return $result;
    }

    public function checkLogin($email, $password)
    {
        $model = new static();
        $model->query = "SELECT * FROM {$model->table_name} WHERE email = '{$email}' AND password = '{$password}'";
        $result = $model->getOne();
        // echo '<pre>';
        // var_dump($result);
        // echo '</pre>';
        return $result;
    }

    public function logOut()
    {
        session_start();
        unset($_SESSION["id"]);
        unset($_SESSION["name"]);
        header("Location:login.php");
    }
}
