<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Verdict;
use Illuminate\Http\Request;
use App\Models\LatexData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function show()
    {

        $generatedAssignment= [];

        return view('student', compact('generatedAssignment') );

    }

    public function generateNewTask()
    {
        $allAssignments = DB::table('latex')
            ->select(
                'id',
                'points',
                'from',
                'to',
                'section',
                'task',
                'equation',
                'solution',
            )
            ->get()
            ->toArray();

        $randomNumber = mt_rand(0, count($allAssignments) - 1);
        $generatedAssignment = array_values($allAssignments)[$randomNumber];


        $studentsAssignments = DB::table('assignments')
            ->leftJoin('latex', 'assignments.latex_id', '=', 'latex.id')
            ->leftJoin('users', 'assignments.user_id', '=', 'users.id')
            ->where('users.id', '=', auth()->user()->id)
            ->insert([
                'points_earned' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => auth()->user()->id,
                'status' => Status::taken,
                'verdict' => Verdict::bad,
                'answer' => '',
                'latex_id' => $generatedAssignment->id,
            ]);




        return view('student', compact('generatedAssignment'));
    }
    public function Janko(){
        $studentsAssignments = DB::table('assignments')
            ->leftJoin('latex', 'assignments.latex_id', '=', 'latex.id')
            ->leftJoin('users', 'assignments.user_id', '=', 'users.id')
            //->where('users.id', '=', $user->id)
            ->insert([
                //'points_earned' => $generatedAssignment->points,
                'created_at' => now(),
                'updated_at' => now(),
                //'user_id' => $user->id,
                'status' => 'unsubmitted',
                'verdict' => 'ungraded',
                'answer' => '',
                //'latex_id' => $generatedAssignment->id,
            ]);
    }



}
