<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class BaseResourceController extends ResourceController {
    protected const MSG_SUCCESS = 'success';
    protected const MSG_SUCCESS_EMPTY = 'empty';
    protected const MSG_DB_ERROR = 'db_error';
    protected const MSG_BALANCE_ERROR = 'balance';
    protected const MSG_NULLABLE = 'null';

    protected $format = 'json';
    protected $helpers = ['url'];

    public function getResponse($data = null, $message = null){
        if (isset($data)){
            if (is_numeric($data) && $data == 0){
                return $this->respond(['status' => 404, 'message' => self::MSG_NULLABLE, 'data' => $data]);
            }

            if (is_array($data)) {
                if (count($data) > 0) {
                    return $this->respond(['status' => 200, 'message' => self::MSG_SUCCESS, 'data' => $data]);
                }
                return $this->respond(['status' => 204, 'message' => self::MSG_SUCCESS_EMPTY, 'data' => $data]);
            }

            if (is_bool($data)){
                if ($data){
                    return $this->respond(['status' => 200, 'message' => self::MSG_SUCCESS, 'data' => $data]);
                }
                return $this->respond(['status' => 404, 'message' => self::MSG_DB_ERROR, 'data' => $data]);
            }

            return $this->respond(['status' => 200, 'message' => self::MSG_SUCCESS, 'data' => $data]);
        }

        return $this->respond(['status' => 404, 'message' => $message ?? self::MSG_NULLABLE, 'data' => null]);
    }

}