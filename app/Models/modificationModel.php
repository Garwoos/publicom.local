<?php

namespace App\Models;

use CodeIgniter\Model;

class modificationModel extends Model
{
    protected $table            = 'modifications'; // Remplacez par le nom réel de votre table
    protected $primaryKey       = 'idModification'; // La clé primaire de la table
    protected $useAutoIncrement = true; // Si la clé primaire est auto-incrémentée
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Si vous utilisez la suppression douce
    protected $protectFields    = true;
    protected $allowedFields    = ['IdMessage', 'mailUser', 'Date', 'oldMessage']; // Champs autorisés pour les inserts/updates

    protected bool $allowEmptyInserts = false; // Interdit les insertions vides
    protected bool $updateOnlyChanged = true; // Mettre à jour uniquement les champs modifiés

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false; // Activez ceci si vous utilisez des timestamps
    protected $dateFormat    = 'datetime'; // Format de date
    protected $createdField  = 'created_at'; // Champ de création, si utilisé
    protected $updatedField  = 'updated_at'; // Champ de mise à jour, si utilisé
    protected $deletedField  = 'deleted_at'; // Champ de suppression douce, si utilisé

    // Validation
    protected $validationRules      = [
        'IdMessage' => 'required|integer',
        'mailUser'  => 'required|valid_email|max_length[255]',
        'Date'      => 'required|valid_date', // Ajustez la règle de validation selon vos besoins
        'oldMessage'=> 'required|string|max_length[255]'
    ];
    protected $validationMessages   = [
        'IdMessage' => [
            'required' => 'Le champ IdMessage est obligatoire.',
            'integer' => 'IdMessage doit être un nombre entier.'
        ],
        'mailUser' => [
            'required' => 'Le champ email est obligatoire.',
            'valid_email' => 'Veuillez fournir un email valide.',
            'max_length' => 'L\'email ne doit pas dépasser 255 caractères.'
        ],
        'Date' => [
            'required' => 'Le champ Date est obligatoire.',
            'valid_date' => 'Veuillez fournir une date valide.' // Ajustez la validation si nécessaire
        ],
        'oldMessage' => [
            'required' => 'Le champ ancien message est obligatoire.',
            'max_length' => 'L\'ancien message ne doit pas dépasser 255 caractères.'
        ]
    ];
    protected $skipValidation       = false; // Sauter la validation par défaut
    protected $cleanValidationRules = true; // Nettoyer les règles de validation

    // Callbacks
    protected $allowCallbacks = true; // Autoriser les callbacks
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
