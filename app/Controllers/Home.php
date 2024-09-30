<?php

namespace App\Controllers;

use App\Models\messageModel;

class Home extends BaseController
{
    public function index(): string
    {
        // Créer une instance du modèle
        $messageModel = new \App\Models\messageModel();

        // Récupérer les données
        $data = $messageModel->findAll();

        // Passer les données à la vue
        return view("index", ['data' => $data]);
    }
}