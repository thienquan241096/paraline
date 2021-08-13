<?php

require_once 'BaseModel.php';

require_once './common_const.php';

class AdminModel extends BaseModel
{
    protected $table_name = 'admin';
    protected $primary_key = 'id';
}