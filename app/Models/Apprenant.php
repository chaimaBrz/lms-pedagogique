<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprenant extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'email', 'user_id', 'telephone', 'date_naissance', 'adresse', 'niveau_etudes'];

    public function formations()
    {
        return $this->belongsToMany(Formation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
