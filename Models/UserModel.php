<?php

require_once 'BaseModel.php';

require_once './common_const.php';

class UserModel extends BaseModel
{
    protected $table_name = 'users';
    protected $primary_key = 'id';
}