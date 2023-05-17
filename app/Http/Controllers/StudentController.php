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

        $generatedAssignment = [];

        return view('student', compact('generatedAssignment'));

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

            $studentId = auth()->user()->id;
            $existingAssignments = DB::table('assignments')
                ->where('user_id', $studentId)
                ->pluck('latex_id')
                ->toArray();

        $availableAssignments = array_values(array_filter($allAssignments, function ($assignment) use ($existingAssignments) {
            return !in_array($assignment->id, $existingAssignments);
        }));


        if (empty($availableAssignments)) {
                //
                return redirect()->back()->with('message', 'Žiadne úlohy nie sú k dispozícii.');
            }

            $randomNumber = mt_rand(0, count($availableAssignments) - 1);
            $generatedAssignment = $availableAssignments[$randomNumber];

            DB::table('assignments')
                ->insert([
                    'points_earned' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'user_id' => $studentId,
                    'status' => Status::taken,
                    'verdict' => Verdict::bad,
                    'answer' => '',
                    'latex_id' => $generatedAssignment->id,
                ]);

            return view('student', compact('generatedAssignment'));
        }
}
