<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['note', 'matiere', 'apprenant_id', 'user_id'];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
