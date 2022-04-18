<?php

namespace App\Controllers\api;

use App\Controllers\BaseResourceController;
use App\Models\BalancesModel;
use App\Models\RequestModel;
use App\Models\TypeRequestModel;
use App\Models\UsersModel;

class RequestsController extends BaseResourceController {
    private const TYPE_DEPOSIT = 1;
    private const TYPE_WITHDRAWALS = 2;
    private const TYPE_TRANSFER = 3;
    private const TYPE_PHONE_CREDIT = 4;

    protected $model = null;
    protected $balanceModel = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new RequestModel();
        $this->balanceModel = new BalancesModel();
    }

    /**
     * Acciones de las solicitudes
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function createRequest(){
        $data = $this->request->getJSON(true);
        $type = $data['id_type'];
        $senderId = $data['id_sender'];
        $receiverId = $data['id_receiver'];
        $amount = floatval($data['amount']);

        // Obtener informacion de los usuarios que realizaran una solicitud
        $senderNewBalance = 0;
        $sender = $this -> balanceModel -> getBalanceByIdUser($senderId);
        $receiver = $this -> balanceModel -> getBalanceByIdUser($receiverId);

        if (!isset($sender) || !isset($receiver)){
            return $this->getResponse();
        }

        // Reemplazar datos del array
        $data['id_sender'] = $sender['id'];
        $data['id_receiver'] = $receiver['id'];
        $senderBalance = floatval($sender['balance']);
        $receiverBalance = floatval($receiver['balance']);

        if ($type == self::TYPE_DEPOSIT){
            $senderNewBalance = $senderBalance + $amount;
        } else {
            $senderNewBalance = $senderBalance - $amount;
            if ($senderNewBalance < floatval(0)){
                return $this->getResponse(null, self::MSG_BALANCE_ERROR);
            }
        }

        // Insert data on Request & update balabce
        $this->model->insert($data);
        $senderUpdated = $this->balanceModel->setBalance($senderId, $senderNewBalance);

        if ($type == self::TYPE_TRANSFER){
            if ($senderUpdated){
                return $this->getResponse($this->balanceModel->setBalance($receiverId, ($receiverBalance + $amount)));
            }
        }

        return $this->getResponse($senderUpdated);
    }

    /**
     * Obtener los movimientos de un usuario dado
     * @param $id
     * @return mixed
     */
    public function getRequestByUser($id){
        return $this->getResponse($this->model->getRequestByIdUser($id));
    }
}