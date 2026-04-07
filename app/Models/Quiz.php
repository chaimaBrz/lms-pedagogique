<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'sous_chapitre_id'];

    public function sousChapitre()
    {
        return $this->belongsTo(SousChapitre::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function resultatQuizzes()
    {
        return $this->hasMany(ResultatQuiz::class);
    }
}
