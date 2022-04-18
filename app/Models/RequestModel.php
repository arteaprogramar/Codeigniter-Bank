<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model {

    protected $table = 'request';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = ['id', 'id_sender', 'id_receiver', 'id_type', 'amount', 'phone', 'latitude', 'longitude', 'created_at', 'update_at'];
    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'update_at';

    /**
     * Obtiene los ultimos 10 movimientos del usuario
     * @param $id
     * @return array|null
     */
    public function getRequestByIdUser($id){
        $balanceModel = new BalancesModel();
        $typeModel = new TypeRequestModel();
        $userModel = new UsersModel();

        $request = $this -> where($this->allowedFields[1], $id)->orderBy($this->allowedFields[0], 'desc')->findAll(10);

        if (!isset($request) || count($request) == 0){
            return null;
        }

        for($index = 0; $index < count($request); $index++){
            $request[$index]['user'] = $userModel->find($request[$index]['id_receiver']);
            $request[$index]['balance'] = $balanceModel->find($request[$index]['id_sender']);
            $request[$index]['type'] = $typeModel->find($request[$index]['id_type']);
        }

        return $request;
    }
}