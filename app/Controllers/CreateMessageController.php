<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MessageModel; // Correctly import the MessageModel class

class CreateMessageController extends BaseController
{
    public function index()
    {
        // Vérification que la requête est bien de type POST
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                                  ->setJSON(['message' => 'Méthode non autorisée']);
        }

        // Récupération des données envoyées depuis le formulaire
        $data = $this->request->getJSON(true); // Utilisation de getJSON pour récupérer les données JSON envoyées par fetch

        $messageModel = new messageModel();

        // Préparation des données pour l'insertion
        $newMessage = [
            'Title'    => $data['title'] ?? '',       // Vérifie que 'title' existe
            'Text'     => $data['text'] ?? '',        // Vérifie que 'text' existe
            'mailUser' => $data['mailUser'] ?? '',    // Vérifie que 'mailUser' existe
            'Online'   => 1,                          // On peut mettre le message directement en ligne (Online = 1)
        ];

        // Validation des données (en fonction des règles définies dans le modèle)
        if (!$messageModel->validate($newMessage)) {
            // Si validation échoue, renvoyer un message d'erreur avec les détails de la validation
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'Erreur de validation', 'errors' => $messageModel->errors()]);
        }

        // Insertion du nouveau message dans la base de données
        try {
            $messageModel->insert($newMessage);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON(['message' => 'Message créé avec succès']);
        } catch (\Exception $e) {
            // Gestion des erreurs d'insertion
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['message' => 'Erreur lors de l\'insertion dans la base de données', 'error' => $e->getMessage()]);
        }
    }
}