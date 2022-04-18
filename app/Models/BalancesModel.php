<?php

namespace App\Models;

use CodeIgniter\Model;

class BalancesModel extends Model {

    protected $table = 'balances';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['id', 'id_user', 'balance', 'created_at', 'update_at'];
    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'update_at';

    /**
     * Crear un balance
     * @param $balance
     * @return \CodeIgniter\Database\BaseResult|false|int|object|string|null
     */
    public function createBalance($balance){
        try {
            return $this->insert($balance);
        } catch (\ReflectionException $ex){
            return null;
        }
    }

    /**
     * Obtiene el balance de un usuario
     * @param $id
     * @return array|object|null
     */
    public function getBalanceByIdUser($id){
        return $this->where($this->allowedFields[1], $id)->first();
    }

    /**
     * Actualizar balance por idUsuario
     * @param $idUser
     * @param $newBalance
     * @return bool
     * @throws \ReflectionException
     */
    public function setBalance($idUser, $newBalance){
        return $this->where($this->allowedFields[1], $idUser)->set([$this->allowedFields[2] => $newBalance])->update();
    }
}