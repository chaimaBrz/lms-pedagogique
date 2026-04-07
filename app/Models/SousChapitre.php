<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousChapitre extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'contenu', 'chapitre_id'];

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    public function contenus()
    {
        return $this->hasMany(Contenu::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
