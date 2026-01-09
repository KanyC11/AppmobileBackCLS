<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Intervenant; // importer le model Intervenant

class Evenement extends Model
{
    protected $table = 'sn_evenement';

    protected $fillable = [
        'libelle',
        'description',
        'date_debut',
        'date_fin',
        'type',
        'lieu',
        'lien', // si tu as ajouté le champ "lien"
    ];

    public function intervenants()
    {
        return $this->belongsToMany(
            Intervenant::class,
            'sn_evenemement_intervenant', // table pivot
            'evenement', // clé étrangère pour Evenement dans la table pivot
            'intervenant' // clé étrangère pour Intervenant dans la table pivot
        );
    }
}
