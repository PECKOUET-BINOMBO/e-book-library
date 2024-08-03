<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'prenom',
        'date_naissance',
        'nationalite',
        'biographie',
        'photo',
    ];

}
