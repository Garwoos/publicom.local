<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MessageModel;
use App\Models\modificationModel;

class MessageController extends BaseController
{
    public function create()
    {
        // Vérification que la requête est bien de type POST
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                                  ->setJSON(['message' => 'Méthode non autorisée']);
        }

        // Récupération des données envoyées depuis le formulaire
        $data = $this->request->getJSON(true); // Utilisation de getJSON pour récupérer les données JSON envoyées par fetch

        $messageModel = new MessageModel();

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

    public function delete()
    {
        // Récupérer l'ID du message à supprimer
        $id = $this->request->getPost('id');

        // Vérifier si l'ID est valide
        if (!is_numeric($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Charger le modèle
        $messageModel = new MessageModel();

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

    public function update()
    {
        // Vérification que la requête est bien de type PUT
        
        if ($this->request->getMethod() !== 'PUT') {
            return $this->response->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                                  ->setJSON(['message' => 'Méthode non autorisée']);
        }

        // Récupération des données envoyées depuis le formulaire
        $data = $this->request->getJSON(true); // Utilisation de getJSON pour récupérer les données JSON envoyées par fetch

        // Récupérer l'ID du message à mettre à jour
        $id = $data['id'] ?? null;

        // Vérifier si l'ID est valide
        if (!is_numeric($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'ID invalide']);
        }

        $messageModel = new MessageModel();

        // Vérifier si le message existe
        $message = $messageModel->find($id);

        if (empty($message)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['message' => 'Message non trouvé']);
        }

        // Préparation de l'historique
        $modificationModel = new modificationModel();
        $newModification = [
            'idMessage' => $id,
            'Title'     => $message['Title'],
            'Text'      => $message['Text'],
            'mailUser'  => $message['mailUser'],
            'Online'    => $message['Online'],
        ];

        // Préparation des données pour la mise à jour
        $updatedMessage = [
            'Title'    => $data['title'] ?? $message['Title'],       // Utiliser la valeur existante si non fournie
            'Text'     => $data['text'] ?? $message['Text'],        // Utiliser la valeur existante si non fournie
            'mailUser' => $data['mailUser'] ?? $message['mailUser'], // Utiliser la valeur existante si non fournie
            'Online'   => 0,    // Utiliser la valeur existante si non fournie
        ];

        // Validation des données (en fonction des règles définies dans le modèle)
        if (!$messageModel->validate($updatedMessage)) {
            // Si validation échoue, renvoyer un message d'erreur avec les détails de la validation
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'Erreur de validation', 'errors' => $messageModel->errors()]);
        }

        // Insertion de l'historique
        try {
            $modificationModel->insert($newModification);
        } catch (\Exception $e) {
            // Gestion des erreurs d'insertion
            
        }

        // Mise à jour du message dans la base de données
        try {
            $messageModel->update($id, $updatedMessage);
            $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON(['message' => 'Message mis à jour avec succès']);
        } catch (\Exception $e) {
            // Gestion des erreurs de mise à jour
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['message' => 'Erreur lors de la mise à jour dans la base de données', 'error' => $e->getMessage()]);
        }
    }

    public function updateOnlineStatus()
    {
        // Vérification que la requête est bien de type PUT
        if ($this->request->getMethod() !== 'PUT') {
            return $this->response->setStatusCode(ResponseInterface::HTTP_METHOD_NOT_ALLOWED)
                                  ->setJSON(['message' => 'Méthode non autorisée']);
        }

        // Récupération des données envoyées depuis le formulaire
        $data = $this->request->getJSON(true); // Utilisation de getJSON pour récupérer les données JSON envoyées par fetch

        // Récupérer l'ID du message à mettre à jour
        $id = $data['id'] ?? null;

        // Vérifier si l'ID est valide
        if (!is_numeric($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'ID invalide']);
        }

        $messageModel = new MessageModel();

        // Vérifier si le message existe
        $message = $messageModel->find($id);

        if (empty($message)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['message' => 'Message non trouvé']);
        }

        // Préparation des données pour la mise à jour
        $updatedMessage = [
            'Online' => $data['online'] ?? $message['Online'], // Utiliser la valeur existante si non fournie
        ];

        // Mise à jour du message dans la base de données
        try {
            $messageModel->update($id, $updatedMessage);
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                  ->setJSON(['message' => 'Statut en ligne mis à jour avec succès']);
        } catch (\Exception $e) {
            // Gestion des erreurs de mise à jour
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['message' => 'Erreur lors de la mise à jour dans la base de données', 'error' => $e->getMessage()]);
        }
    }
}