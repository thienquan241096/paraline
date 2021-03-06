<?php

namespace App\Models;

require_once 'IBaseModel.php';

use PDO;

abstract class BaseModel implements IBaseModel
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

    public static function paginate($del_flag = DEL_FALG, $page = LIMIT)
    {
        $model = new static();
        $rowPerPage = $page;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $model->query = "SELECT COUNT(*) AS total FROM {$model->table_name} WHERE del_flag = $del_flag";
        $totalRow = (int)($model->getOne()->total);
        $totalPage = ceil($totalRow / $rowPerPage);

        if ($currentPage < 1) {
            $current_page = 1;
        }

        if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $rowPerPage;

        $model->query = "SELECT * FROM {$model->table_name} WHERE del_flag = $del_flag ORDER BY id DESC LIMIT {$start},{$rowPerPage}";

        $_SESSION['totalPage'] = $totalPage;
        $_SESSION['prePage'] = ($currentPage > 1) ? ($currentPage - 1) : 1;
        $_SESSION['nextPage'] = ($currentPage < $totalPage) ? ($currentPage + 1) : $totalPage;

        return $model->get();
    }

    public static function insert($arr)
    {
        $model = new static();

        $arr['ins_id'] = isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : "";
        $arr['upd_id'] = isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : "";
        $arr['ins_datetime'] = INS_DATETIME;
        $arr['upd_datetime'] = UPD_DATETIME;
        $arr['del_flag'] = DEL_FALG;

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
        $statement = $model->conn->prepare($model->query);
        $statement->execute($arr);

        return $model->conn->lastInsertId();
    }

    public static function delete($id, $params)
    {
        unset($params['id']);
        $model = new static();
        $params['upd_datetime'] = UPD_DATETIME;
        $model->query = "UPDATE {$model->table_name} SET ";
        foreach ($params as $key => $value) {
            $model->query .= " $key = :$key, ";
        }
        $model->query = rtrim($model->query, ', ');

        $model->query .= " WHERE id = $id";

        $statement = $model->conn->prepare($model->query);

        $statement->execute($params);

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
        $params['upd_id'] = $_SESSION['admin']['id'];
        $params['upd_datetime'] = UPD_DATETIME;
        $params['del_flag'] = DEL_FALG;

        $model->query = "UPDATE {$model->table_name} SET ";
        foreach ($params as $key => $value) {
            $model->query .= " $key = :$key, ";
        }
        $model->query = rtrim($model->query, ', ');

        $model->query .= " WHERE id = $id";

        $statement = $model->conn->prepare($model->query);

        $statement->execute($params);

        return $id;
    }

    public static function search($colName = COL_NAME, $colEmail = COL_EMAIL, $condition, $searchValue, $del_flag = DEL_FALG)
    {
        $model = new static();
        $query = "SELECT * FROM " . $model->table_name . " WHERE del_flag = $del_flag AND ($colName $condition '$searchValue'
        OR $colEmail $condition '$searchValue') ";
        $statement = $model->conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function findEmailByID($id, $del_flag = DEL_FALG)
    {
        $model = new static();

        $model->query = "SELECT email FROM {$model->table_name} WHERE {$model->primary_key} != $id AND del_flag = $del_flag";
        $result = $model->get();
        return $result;
    }

    abstract function historyDelete();

    public function get()
    {
        $statement = $this->conn->prepare($this->query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        return $statement->fetchAll();
    }

    public function getOne()
    {
        $statement = $this->conn->prepare($this->query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        return $statement->fetch();
    }

    public function findByEmail($email, $del_flag = DEL_FALG)
    {
        $model = new static();
        $model->query = "SELECT * FROM {$model->table_name} WHERE email = '$email' AND del_flag = $del_flag";
        $result = $model->getOne();
        return $result;
    }

    public function checkLogin($email, $password)
    {
        $model = new static();
        $model->query = "SELECT * FROM {$model->table_name} WHERE email = '{$email}' AND password = '{$password}'";
        $result = $model->getOne();
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