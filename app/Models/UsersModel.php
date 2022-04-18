<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['id', 'name', 'first_name', 'clabe', 'pin', 'created_at', 'update_at'];
    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'update_at';

    /**
     * Crear un nuevo usuario con balance
     *
     * @param $user
     * @param $balance
     * @return \CodeIgniter\Database\BaseResult|false|int|object|string|null
     */
    public function createUserBalance($user, $balance){
        $balanceModel = new BalancesModel();

        try {
            $getIdUser = $this->insert($user);
            if (is_numeric($getIdUser)){
                $balance['id_user'] = $getIdUser;
                $balanceModel -> createBalance($balance);
            }

            return $getIdUser;
        } catch (\ReflectionException $ex) {
            return null;
        }
    }

    /**
     * Obtener todas las clabes
     * @return array|null
     */
    public function getAllClabe(){
        return $this->findColumn($this->allowedFields[3]);
    }

    /**
     * Obtener usuario si existe segun clabe y pin
     * @param $clabe
     * @param $pin
     * @return array|object|null
     */
    public function getUserByClabePin($clabe, $pin){
        return $this->where($this->allowedFields[3], $clabe)->where($this->allowedFields[4], $pin)->first();
    }

    /**
     * Obtener el usuario y el balance
     * @param $clabe
     * @return array|object|null
     */
    public function getUserBalanceByClabe($clabe){
        $balanceModel = new BalancesModel();
        $user = $this->where($this->allowedFields[3], $clabe)->first();

        if (!isset($user) || count($user) == 0){
            return null;
        }

        $user['balance'] = $balanceModel->where('id_user', $user['id'])->first();
        return $user;
    }
}