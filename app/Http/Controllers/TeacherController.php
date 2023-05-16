<?php

namespace App\Http\Controllers;

use App\Models\LatexData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function table() {
        $users = DB::table('users')
            ->leftJoin('assignments', 'users.id', '=', 'assignments.user_id')
            ->leftJoin('latex', 'assignments.latex_id', '=', 'latex.id')
            ->select(
                'users.id',
                'users.name',
                'users.surname',
                DB::raw('COUNT(assignments.id) as assignment_count'),
                DB::raw('CAST(COALESCE(SUM(latex.points), 0) AS SIGNED) as total_points')
            )
            ->where('users.is_teacher', '=', 0)
            ->groupBy('users.id', 'users.name', 'users.surname')
            ->get();

        return view('table', compact('users'));
    }

    public function studentTable() {
        return view('studentTable', [
            'files' => LatexData::select('*')
                ->groupBy('name')
                ->get(),
        ]);
    }
}


