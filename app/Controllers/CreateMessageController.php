<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CreateMessageController extends BaseController
{
    public function index()
    {
        // Validation setup
        $validation = \Config\Services::validation();

        // Set rules to ensure required fields are provided
        $validation->setRules([
            'title' => 'required',          // Ensure title is provided
            'text' => 'required',           // Ensure text/description is provided
            'mailUser' => 'required|valid_email'  // Ensure a valid email is provided
        ]);

        // If validation fails, return an error response
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                 ->setJSON(['message' => 'Données invalides.', 'errors' => $validation->getErrors()]);
        }

        // Extract the data from the request
        $title = $this->request->getPost('title');
        $text = $this->request->getPost('text');
        $mailUser = $this->request->getPost('mailUser');
        $online = 0;  // Default value for 'online'

        // Load the MessageModel
        $messageModel = new \App\Models\MessageModel();

        // Try inserting into the database
        try {
            $messageModel->insert([
                'Title' => $title,
                'Text' => $text,
                'Online' => $online,
                'mailUser' => $mailUser,
            ]);

            // Return success message
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
                                 ->setJSON(['message' => 'Evènement créé avec succès.']);
        } catch (\Exception $e) {
            // Handle database errors
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                                 ->setJSON(['message' => 'Erreur lors de la création de l\'évènement : ' . $e->getMessage()]);
        }
    }
}