<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'utilisateur';
    protected $primaryKey       = 'mailUser'; // Correspond à la clé primaire
    protected $useAutoIncrement = false; // Puisque la clé primaire n'est pas auto-incrémentée
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mailUser', 'username', 'passwordUser']; // Champs autorisés pour les inserts/updates

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'mailUser' => 'required|valid_email|max_length[255]',
        'username' => 'required|max_length[255]',
        'passwordUser' => 'required|min_length[8]|max_length[255]'
    ];
    protected $validationMessages   = [
        'mailUser' => [
            'required' => 'Le champ email est obligatoire.',
            'valid_email' => 'Veuillez fournir un email valide.',
            'max_length' => 'L\'email ne doit pas dépasser 255 caractères.'
        ],
        'username' => [
            'required' => 'Le champ nom d\'utilisateur est obligatoire.',
            'max_length' => 'Le nom d\'utilisateur ne doit pas dépasser 255 caractères.'
        ],
        'passwordUser' => [
            'required' => 'Le mot de passe est obligatoire.',
            'min_length' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}

