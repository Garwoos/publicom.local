<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HistoriqueController extends BaseController
{
    public function history($id)
    {
        $messageModel = new \App\Models\messageModel();
        $message = $messageModel->find($id);
        $historiqueModel = new \App\Models\historiqueModel();
        return view('history', ['data' => $historiqueModel->where('idMessage', $id)->findAll(), 'message' => $message]);

    }
}