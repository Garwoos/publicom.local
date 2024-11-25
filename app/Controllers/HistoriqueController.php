<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HistoriqueController extends BaseController
{
    public function history($id)
    {
        $messageModel = new \App\Models\MessageModel();
        $message = $messageModel->find($id);
        $historiqueModel = new \App\Models\HistoriqueModel();
        return view('history', ['data' => $historiqueModel->where('idMessage', $id)->findAll(), 'message' => $message]);

    }
}
