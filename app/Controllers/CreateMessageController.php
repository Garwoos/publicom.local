<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CreateMessageController extends BaseController
{
    public function index()
    {
        // Récupérer les données du formulaire
        $title = $this->request->getPost('title');
        $text = $this->request->getPost('text');
        $online = $this->request->getPost('online');
        $mailUser = $this->request->getPost('mailUser');

        // Charger le modèle
        $messageModel = new \App\Models\messageModel();

        // Créer un nouveau message
        $messageModel->insert([
            'Title' => $title,
            'Text' => $text,
            'Online' => $online,
            'mailUser' => $mailUser,
        ]);

        // Rediriger vers la page d'accueil
        return redirect()->to('/');
    }
}
