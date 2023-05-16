<?php

namespace App\Http\Controllers;

use App\Models\LatexData;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher', [
            'files' => LatexData::select('*')
                ->groupBy('name')
                ->get(),
        ]);
    }

    public function edit(Request $request, $name) {
        $from = $request->input('from');
        $to = $request->input('to');
        $points = $request->input('points');



        LatexData::where('name', $name)
            ->update([
                'from' => $from,
                'to' => $to,
                'points' => $points,
            ]);

        return redirect()->back();
    }
}
