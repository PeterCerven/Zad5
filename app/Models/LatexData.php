<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatexData extends Model
{
    use HasFactory;
    protected $table = 'latex';
    protected $fillable = ['name', 'section', 'task', 'equation', 'eq_text', 'solution', 'eq_conditions', 'image_name'];

    public function __construct($name='', $section='', $task='', $equation='', $eq_text='', $solution='', $eq_conditions='', $image_name='')
    {
        parent::__construct();
        $this->fill([
            'name' => $name,
            'section' => $section,
            'task' => $task,
            'equation' => $equation,
            'eq_text' => $eq_text,
            'solution' => $solution,
            'eq_conditions' => $eq_conditions,
            'image_name' => $image_name,
        ]);
    }
    public static function isLatexFileinDB($name)
    {
        return self::where('name', $name)->first();
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
