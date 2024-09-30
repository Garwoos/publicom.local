<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UpdateMessageController extends BaseController
{
    public function index()
    {
        // Récupérer les données du formulaire
        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $text = $this->request->getPost('text');
        $online = $this->request->getPost('online');
        $mailUser = $this->request->getPost('mailUser');

        // Charger le modèle
        $messageModel = new \App\Models\messageModel();

        // Vérifier si le message existe
        $message = $messageModel->find($id);

        if (empty($message)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Mettre à jour le message
        $messageModel->update($id, [
            'Title' => $title,
            'Text' => $text,
            'Online' => $online,
            'mailUser' => $mailUser,
        ]);

        // Rediriger vers la page d'accueil
        return redirect()->to('/');
    }
}
