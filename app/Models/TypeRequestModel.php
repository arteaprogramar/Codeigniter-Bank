<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeRequestModel extends Model {

    protected $table = 'type_request';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['id', 'name', 'created_at', 'update_at'];
    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'update_at';

}