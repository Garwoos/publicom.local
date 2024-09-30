<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginUserController extends BaseController
{
    public function index()
    {
        // Récupérer les données du formulaire envoyées en JSON
        $data = $this->request->getJSON(true); // true pour récupérer en tableau
        
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        
        if (!$email || !$password) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['message' => 'Email ou mot de passe manquant.']);
        }
        
        // Charger le modèle
        $userModel = new \App\Models\UserModel();
        
        // Vérifier si l'utilisateur existe en utilisant le mailUser
        $user = $userModel->where('mailUser', $email)->first();
        
        if (empty($user)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['message' => 'Utilisateur non trouvé.']);
        }
        
        // Vérifier le mot de passe (comparer avec passwordUser)
        if (!password_verify($password, $user['passwordUser'])) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                                  ->setJSON(['message' => 'Mot de passe incorrect.']);
        }
        
        // Créer une session
        $session = session();
        $session->set('user', $user);
        
        // Retourner un succès avec un message JSON
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                              ->setJSON(['message' => 'Connexion réussie.']);
    }
}
