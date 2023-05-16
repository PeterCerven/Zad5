<?php

namespace App\Http\Controllers;

use App\Models\LatexData;
use App\Models\User;
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
            ->select(
                'users.id',
                'users.name',
                'users.surname',
                DB::raw('COUNT(assignments.id) as assignment_count'),
                DB::raw('CAST(COALESCE(SUM(assignments.points_earned), 0) AS SIGNED) as total_points')
            )
            ->where('users.is_teacher', '=', 0)
            ->groupBy('users.id', 'users.name', 'users.surname')
            ->get();

        return view('tables.table', compact('users'));
    }

    public function studentTable(User $user) {
        $assignments = DB::table('assignments')
            ->leftJoin('latex', 'assignments.latex_id', '=', 'latex.id')
            ->leftJoin('users', 'assignments.user_id', '=', 'users.id')
            ->select(
                'assignments.id',
                'users.name as first_name',
                'users.surname as last_name',
                'latex.task',
                'latex.equation',
                'latex.solution',
                'assignments.status',
                'assignments.verdict',
                'assignments.answer',
                'assignments.points_earned',
            )
            ->where('assignments.user_id', '=', $user->id)
            ->get();


        return view('tables.studentTable', compact('assignments'));
    }
}


