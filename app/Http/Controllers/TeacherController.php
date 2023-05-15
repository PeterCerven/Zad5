<?php

namespace App\Http\Controllers;

use App\Models\LatexData;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher', [
            'files' => LatexData::select('name')
                ->groupBy('name')
                ->get(),
        ]);
    }
}
