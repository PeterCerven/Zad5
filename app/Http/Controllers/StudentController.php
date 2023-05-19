<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Verdict;
use Illuminate\Http\Request;
use App\Models\LatexData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use node_modules\mathjs\dist\math;


class StudentController extends Controller
{
    public function show()
    {

        $generatedAssignment = [];
        $assignments = [];

        return view('student', compact('generatedAssignment', 'assignments'));

    }

    public function generateNewTask()

    {
        $assignments = [];
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

            return view('student', compact('generatedAssignment', 'assignments'));
        }

        public function showTasks (){

            $studentId = auth()->user()->id;
            $assignments = DB::table('assignments')
                ->join('latex', 'assignments.latex_id', '=', 'latex.id')
                ->select(
                    'assignments.id',
                    'assignments.points_earned',
                    'assignments.status',
                    'assignments.verdict',
                    'assignments.answer',
                    'latex.points',
                    'latex.from',
                    'latex.to',
                    'latex.section',
                    'latex.task',
                    'latex.equation',
                    'latex.solution',
                    'latex.image_name',
                )
                ->where('assignments.user_id', $studentId)
                ->get()
                ->toArray();

            return view('studentTasks', compact('assignments'));
        }

        public function showTask($assignment_id)
        {
            $studentId = auth()->user()->id;
            $assignment = DB::table('assignments')
                ->join('latex', 'assignments.latex_id', '=', 'latex.id')
                ->select(
                    'assignments.id',
                    'assignments.points_earned',
                    'assignments.status',
                    'assignments.verdict',
                    'assignments.answer',
                    'latex.points',
                    'latex.from',
                    'latex.to',
                    'latex.section',
                    'latex.task',
                    'latex.equation',
                    'latex.solution',
                    'latex.image_name',
                )
                ->where('assignments.user_id', $studentId)
                ->where('assignments.id', $assignment_id)
                ->get();

            return view('studentTask', compact('assignment'));


        }

        public function submitTask ($assignment_id)
        {
            $studentId = auth()->user()->id;
            $assignment = DB::table('assignments')
                ->join('latex', 'assignments.latex_id', '=', 'latex.id')
                ->select(
                    'assignments.id',
                    'assignments.points_earned',
                    'assignments.status',
                    'assignments.verdict',
                    'assignments.answer',
                    'latex.points',
                    'latex.from',
                    'latex.to',
                    'latex.section',
                    'latex.task',
                    'latex.equation',
                    'latex.solution',
                )
                ->where('assignments.user_id', $studentId)
                ->where('assignments.id', $assignment_id)
                ->get()
                ->toArray();



            $answer = request()->input('answer');

            $verdict = Verdict::bad;
            $points_earned = 0;

            if ($answer == $assignment[0]->solution) {
                $verdict = Verdict::good;
                $points_earned = $assignment[0]->points;
            }

            DB::table('assignments')
                ->where('id', $assignment_id)
                ->update([
                    'answer' => $answer,
                    'verdict' => $verdict,
                    'points_earned' => $points_earned,
                    'status' => Status::submitted,
                ]);

            return redirect()->back()->with('message', 'Úloha bola odoslaná.');
        }
}
