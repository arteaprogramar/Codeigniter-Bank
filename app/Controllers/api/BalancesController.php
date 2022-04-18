<?php

namespace App\Controllers\api;

use App\Controllers\BaseResourceController;
use App\Models\BalancesModel;
use App\Models\UsersModel;

class BalancesController extends BaseResourceController {

    protected $model = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new BalancesModel();
    }

    public function getBalanceByIdUser($id){
        return $this->getResponse($this->model->find($id));
    }

}