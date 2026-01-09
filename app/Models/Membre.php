<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    protected $table = 'sn_membres';

    protected $fillable = [
        'prenom',
        'nom'
    ];

    public function podcasts()
    {
        return $this->hasMany(Podcast::class, 'membre_id');
    }
}
