<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'latex_id',
        'name',
        'section',
        'task',
        'equation',
        'eq_text',
        'solution',
        'eq_conditions',
        'image_name',
        'from',
        'to',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function latex()
    {
        return $this->belongsTo(LatexData::class);
    }
}
