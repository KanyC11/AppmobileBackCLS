<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'sn_categorie';

    protected $fillable = [
        'libelle'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'categorie');
    }

    public function podcasts()
    {
        return $this->hasMany(Podcast::class, 'categorie');
    }
}
