<?php

namespace App\Controllers\api;

use App\Controllers\BaseResourceController;
use App\Models\BalancesModel;
use App\Models\UsersModel;

class UsersController extends BaseResourceController {

    protected $model = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new UsersModel();
    }

    /**
     * Permite crear un nuevo usuario y balance
     * @return mixed
     */
    public function create(){
        $user = $this->request->getJSON(true);
        $balance = $user['balance'];
        $response = $this -> model -> createUserBalance($user, $balance);
        return $this->getResponse($response);
    }

    /**
     * Obtener todas las clabes del los usuarios
     * @return mixed|null
     */
    public function getAllClabe(){
        $result = $this->model->getAllClabe();

        if (isset($result) && count($result) > 0){
            return $this->getResponse(array_map('intval', $result));
        }

        return $this->getResponse();
    }

    /**
     * Obtener usuario por clabe y pin
     * @param $clabe
     * @param $pin
     * @return array|mixed
     */
    public function getUser($clabe, $pin = null){
        if (isset($pin)){
            return $this->getResponse($this->model->getUserByClabePin($clabe, $pin));
        }

        return $this->getResponse($this->model->getUserBalanceByClabe($clabe));
    }

}