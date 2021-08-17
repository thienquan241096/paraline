<?php

namespace App\Models;

require_once 'BaseModel.php';

class UserModel extends BaseModel
{
    protected $table_name = 'users';
    protected $primary_key = 'id';
}