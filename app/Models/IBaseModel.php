<?php

namespace App\Models;

interface IBaseModel
{
    public static function all($del_flag = DEL_FALG);

    public static function insert($arr);

    public static function delete($id, $params);

    public static function find($id, $del_flag = DEL_FALG);

    public static function update($id, $params);

    public static function search($colName = COL_NAME, $colEmail = COL_EMAIL, $condition, $searchValue, $del_flag = DEL_FALG);

    public function get();

    function historyDelete();

    public function getOne();

    public static function paginate($del_flag = DEL_FALG, $page);

    public function findByEmail($email, $del_flag = DEL_FALG);
}