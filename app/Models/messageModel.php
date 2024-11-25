<?php

namespace App\Models;

use CodeIgniter\Model;

class messageModel extends Model
{
    protected $table            = 'message';
    protected $primaryKey       = 'idMessage';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['Title', 'Text', 'Online', 'mailUser']; // Champs modifiables

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casts pour typage automatique
    protected array $casts = [
        'Online' => 'boolean', // Conversion de tinyint(1) en booléen
    ];

    // Dates
    protected $useTimestamps = false; // Pas de gestion automatique des timestamps
    protected $dateFormat    = 'datetime'; // Format de date par défaut

    // Validation
    protected $validationRules      = [
        'Title'    => 'required|max_length[255]',
        'Text'     => 'required|max_length[255]',
        'Online'   => 'in_list[0,1]', // Valide uniquement 0 ou 1
        'mailUser' => 'required|valid_email|max_length[255]', // Validation de l'email
    ];
    protected $validationMessages   = [
        'Title' => [
            'required'    => 'Le titre est obligatoire',
            'max_length'  => 'Le titre ne peut pas dépasser 255 caractères',
        ],
        'Text' => [
            'required'    => 'Le texte est obligatoire',
            'max_length'  => 'Le texte ne peut pas dépasser 255 caractères',
        ],
        'mailUser' => [
            'required'    => "L'adresse mail de l'utilisateur est obligatoire",
            'valid_email' => "L'adresse mail doit être valide",
            'max_length'  => "L'adresse mail ne peut pas dépasser 255 caractères",
        ],
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
