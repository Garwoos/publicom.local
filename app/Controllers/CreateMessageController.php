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
        //vaut faux par défaut
        $online = $this->request->getPost('online') ? true : false;
        $mailUser = $this->request->getPost('mailUser');

        if (!$title || !$text || !$mailUser) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'Données manquantes.']);
        }

        // Charger le modèle
        $messageModel = new \App\Models\MessageModel();

        // Tenter l'insertion dans la base de données
        try {
            $messageModel->insert([
                'Title' => $title,
                'Text' => $text,
                'Online' => $online,
                'mailUser' => $mailUser,
            ]);
            // Rediriger vers la page d'accueil
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON(['message' => 'Evènement créé avec succès.']);
        } catch (\Exception $e) {
            // En cas d'erreur
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['message' => 'Erreur lors de la création de l\'évènement : ' . $e->getMessage()]);
        }
    }
}