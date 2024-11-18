<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\modificationModel;

class ModificationController extends BaseController
{
    public function history($id)
    {
        $modificationModel = new modificationModel();
        $modifications = $modificationModel->where('idMessage', $id)->findAll();
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                              ->setJSON($modifications);
    }

}