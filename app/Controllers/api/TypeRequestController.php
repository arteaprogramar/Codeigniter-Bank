<?php

namespace App\Controllers\api;

use App\Controllers\BaseResourceController;
use App\Models\BalancesModel;
use App\Models\TypeRequestModel;
use App\Models\UsersModel;

class TypeRequestController extends BaseResourceController {

    protected $model = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new TypeRequestModel();
    }

    /**
     * Obtener todas las solicitudes
     * @return mixed
     */
    public function getAll(){
        return $this->getResponse($this->model->findAll());
    }

}