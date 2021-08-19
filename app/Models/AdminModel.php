<?php

namespace App\Models;

require_once 'BaseModel.php';

class AdminModel extends BaseModel
{
    protected $table_name = 'admin';
    protected $primary_key = 'id';

    public function historyDelete($del_flag = DESTROY)
    {
        $model = new static();
        $model->query = "SELECT * FROM {$model->table_name} WHERE del_flag = $del_flag";
        return $model->get();
    }
}
