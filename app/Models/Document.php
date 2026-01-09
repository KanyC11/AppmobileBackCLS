<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'sn_document';

    protected $fillable = [
        'libelle',
        'categorie',
        'fichier',
        'description'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie');
    }
}
