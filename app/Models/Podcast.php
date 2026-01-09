<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $table = 'sn_podcast';

    protected $fillable = [
        'libelle',
        'description',
        'membre',
        'fichier',
        'categorie'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie');
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class, 'membre');
    }
}
