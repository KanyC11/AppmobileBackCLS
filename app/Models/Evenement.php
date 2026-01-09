<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'lien'
    ];

    public function intervenants()
    {
        return $this->belongsToMany(
            Intervenant::class,
            'sn_evenemement_intervenant',
            'evenement',
            'intervenant'
        );
    }
}
