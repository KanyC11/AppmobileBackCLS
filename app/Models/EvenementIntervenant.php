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
        'lien', 
    ];

    public function intervenants()
    {
        return $this->belongsToMany(
            Intervenant::class,
            'sn_evenement_intervenant', 
            'evenement_id', 
            'intervenant_id' 
        );
    }
}
