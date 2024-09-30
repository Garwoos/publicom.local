<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DeleteMessageController extends BaseController
{
    public function index()
    {
        // Récupérer l'ID du message à supprimer
        $id = $this->request->getPost('id');

        // Vérifier si l'ID est valide
        if (!is_numeric($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Charger le modèle
        $messageModel = new \App\Models\messageModel();

        // Vérifier si le message existe
        $message = $messageModel->find($id);

        if (empty($message)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        // Supprimer le message
        $messageModel->delete($id);

        // Rediriger vers la page d'accueil
        return redirect()->to('/');
    }
}
