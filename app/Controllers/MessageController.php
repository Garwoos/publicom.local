<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\historiqueModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\messageModel;
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

        // Création d'un tableau associatif avec les données du message
        $newMessage = [
            'Title'         => $data['title'] ?? null,
            'Text'          => $data['text'] ?? null,
            'mailUser'      => $data['mailUser'] ?? null,
            'Online'        => 0, 
            'image'         => $data['image'] ?? null,
            'fontTitle'     => $data['fontTitle'] ?? null,
            'sizeTitle'     => $data['sizeTitle'] ?? null,
            'fontText'      => $data['fontText'] ?? null,
            'sizeText'      => $data['sizeText'] ?? null,
            'alignmentText' => $data['alignmentText'] ?? null,
        ];

        // Charger le modèle
        $messageModel = new messageModel();

        // Validation des données (en fonction des règles définies dans le modèle)
        if (!$messageModel->validate($newMessage)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'Erreur de validation', 'errors' => $messageModel->errors()]);
        }

        // Insertion du message dans la base de données
        try {
            $messageModel->insert($newMessage);
            return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
                                  ->setJSON(['message' => 'Message créé avec succès']);
        } catch (\Exception $e) {
            // Gestion des erreurs d'insertion
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                  ->setJSON(['message' => 'Erreur lors de l\'enregistrement dans la base de données', 'error' => $e->getMessage]);
    }
}

    public function delete()
    {
        // Récupérer l'ID du message à supprimer
        $id = $this->request->getPost('id');
        log_message('debug', 'ID de suppression : ' . $id); // Débogage pour vérifier l'ID

        // Vérifier si l'ID est valide
        if (!is_numeric($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Charger le modèle
        $messageModel = new messageModel();

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

    $messageModel = new messageModel();

    // Vérifier si le message existe
    $message = $messageModel->find($id);

    if (empty($message)) {
        return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                              ->setJSON(['message' => 'Message non trouvé']);
    }

    // Préparation de l'historique
    $modificationModel = new historiqueModel();
    $newModification = [
        'IdMessage'  => $id,
        'mailUser'   => $message['mailUser'],
        'Date'       => date('Y-m-d H:i:s'),
        'oldMessage' => $message['Text']
    ];

    // Préparation des données pour la mise à jour
    $updatedMessage = [
        'Title'         => $data['title'] ?? $message['Title'],
        'Text'          => $data['text'] ?? $message['Text'],
        'mailUser'      => $data['mailUser'] ?? $message['mailUser'],
        'Online'        => 0, // Vous pouvez changer cette logique si nécessaire
        'image'         => $data['image'] ?? $message['image'],
        'fontTitle'     => $data['fontTitle'] ?? $message['fontTitle'],
        'sizeTitle'     => $data['sizeTitle'] ?? $message['sizeTitle'],
        'fontText'      => $data['fontText'] ?? $message['fontText'],
        'sizeText'      => $data['sizeText'] ?? $message['sizeText'],
        'alignmentText' => $data['alignmentText'] ?? $message['alignmentText'],
    ];

    // Validation des données (en fonction des règles définies dans le modèle)
    if (!$messageModel->validate($updatedMessage)) {
        return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                              ->setJSON(['message' => 'Erreur de validation', 'errors' => $messageModel->errors()]);
    }

    // Insertion de l'historique
    try {
        $modificationModel->insert($newModification);
    } catch (\Exception $e) {
        // Gestion des erreurs d'insertion de l'historique
        return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                              ->setJSON(['message' => 'Erreur lors de l\'enregistrement de l\'historique', 'error' => $e->getMessage()]);
    }

    // Mise à jour du message dans la base de données
    try {
        $messageModel->update($id, $updatedMessage);
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
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

        $messageModel = new messageModel();

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