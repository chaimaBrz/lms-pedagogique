<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'niveau', 'duree'];

    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
    }

    public function apprenants()
    {
        return $this->belongsToMany(Apprenant::class);
    }
}
