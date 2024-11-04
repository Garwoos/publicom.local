<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MessageModel;

class Modify extends BaseController
{
    public function index($id)
    {
        $session = session();

        if (!$session->has('user')) {
            return redirect()->to('/login');
        }

        $messageModel = new MessageModel();
        $message = $messageModel->find($id);

        if (!$message) {
            return redirect()->to('/')->with('error', 'Message non trouvé');
        }

        $data = [
            'messageId' => $message['idMessage'],
            'messageTitle' => $message['Title'],
            'messageDescription' => $message['Text'],
        ];

        return view('saveMessage', $data);
    }
}
