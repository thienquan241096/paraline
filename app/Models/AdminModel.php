<?php

namespace App\Models;

require_once 'BaseModel.php';

class AdminModel extends BaseModel
{
    protected $table_name = 'admin';
    protected $primary_key = 'id';
}