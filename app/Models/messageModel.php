<?php

namespace App\Models;

use CodeIgniter\Model;

class messageModel extends Model
{
    protected $table            = 'message'; // Nom de la table
    protected $primaryKey       = 'idMessage'; // Clé primaire
    protected $useAutoIncrement = true; // Si la clé primaire est auto-incrémentée
    protected $returnType       = 'array'; // Type de retour des résultats
    protected $useSoftDeletes   = false; // Pas de suppression douce ici
    protected $protectFields    = true; // Protéger les champs pour les mises à jour
    protected $allowedFields    = [
        'Title', 'Text', 'Online', 'mailUser', 'image', 
        'fontTitle', 'sizeTitle', 'fontText', 'sizeText', 'aligmentText'
    ]; // Champs autorisés pour les inserts/updates

    protected bool $allowEmptyInserts = false; // Interdit les insertions vides
    protected bool $updateOnlyChanged = true; // Mettre à jour uniquement les champs modifiés

    protected array $casts = []; // Vous pouvez ajouter des casts ici si nécessaire
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false; // Pas de timestamps ici
    protected $dateFormat    = 'datetime'; // Format de date
    protected $createdField  = 'created_at'; // Champ de création, à ajuster si nécessaire
    protected $updatedField  = 'updated_at'; // Champ de mise à jour, à ajuster si nécessaire
    protected $deletedField  = 'deleted_at'; // Champ de suppression douce, à ajuster si nécessaire

    // Validation
    protected $validationRules = [
        'Title'      => 'required|string|max_length[255]',
        'Text'       => 'required|string|max_length[255]',
        'Online'     => 'required|in_list[0,1]',
        'mailUser'   => 'required|valid_email|max_length[255]',
        'image'      => 'required|string|max_length[500]',
        'fontTitle'  => 'required|integer',
        'sizeTitle'  => 'required|integer',
        'fontText'   => 'required|integer',
        'sizeText'   => 'required|integer',
        'aligmentText'=> 'required|integer'
    ];

    protected $validationMessages = [
        'Title' => [
            'required' => 'Le champ Titre est obligatoire.',
            'string'   => 'Le Titre doit être une chaîne de caractères.',
            'max_length' => 'Le Titre ne doit pas dépasser 255 caractères.'
        ],
        'Text' => [
            'required' => 'Le champ Texte est obligatoire.',
            'string'   => 'Le Texte doit être une chaîne de caractères.',
            'max_length' => 'Le Texte ne doit pas dépasser 255 caractères.'
        ],
        'Online' => [
            'required' => 'Le champ Online est obligatoire.',
            'in_list'  => 'Le champ Online doit être 0 ou 1.'
        ],
        'mailUser' => [
            'required'    => 'Le champ email est obligatoire.',
            'valid_email' => 'Veuillez fournir un email valide.',
            'max_length'  => 'L\'email ne doit pas dépasser 255 caractères.'
        ],
        'image' => [
            'required'   => 'Le champ image est obligatoire.',
            'string'     => 'L\'image doit être une chaîne de caractères.',
            'max_length' => 'L\'image ne doit pas dépasser 500 caractères.'
        ],
        'fontTitle' => [
            'required' => 'Le champ fontTitle est obligatoire.',
            'integer'  => 'fontTitle doit être un nombre entier.'
        ],
        'sizeTitle' => [
            'required' => 'Le champ sizeTitle est obligatoire.',
            'integer'  => 'sizeTitle doit être un nombre entier.'
        ],
        'fontText' => [
            'required' => 'Le champ fontText est obligatoire.',
            'integer'  => 'fontText doit être un nombre entier.'
        ],
        'sizeText' => [
            'required' => 'Le champ sizeText est obligatoire.',
            'integer'  => 'sizeText doit être un nombre entier.'
        ],
        'aligmentText' => [
            'required' => 'Le champ aligmentText est obligatoire.',
            'integer'  => 'aligmentText doit être un nombre entier.'
        ]
    ];

    protected $skipValidation       = true; // Ne pas sauter la validation
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
