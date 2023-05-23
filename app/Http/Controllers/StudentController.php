<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Verdict;
use Illuminate\Http\Request;
use App\Models\LatexData;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use node_modules\mathjs\dist\math;
//use vendor/mossadal/math-parser;
use MathParser\StdMathParser;
use MathParser\Interpreting\Evaluator;

class StudentController extends Controller
{
    public function show()
    {

        $generatedAssignment = [];
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
            ->where('assignments.user_id', auth()->user()->id)
            ->get()
            ->toArray();

        return view('student', compact( 'assignments'));

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
            if (PHP_OS === 'WINNT') {
                $maxima_path = "C:/maxima-5.46.0/bin/maxima.bat";
            } else {
                $maxima_path = "/usr/bin/maxima";
            }
            $answer = request()->input('answer');

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

            $equation =$this->latexToMaxima($answer);

            $latexSolution =$this->latexToMaxima($assignment[0]->solution);

            if (preg_match('~^[0-9+\-*/]+$~', $latexSolution) && preg_match('~^[0-9+\-*/]+$~', $equation)) {
                $parser = new StdMathParser();
                $evaluator = new Evaluator();

                $value1 = $parser->parse($equation)->accept($evaluator);
                $value2 = $parser->parse($latexSolution)->accept($evaluator);

                try {
                    if ($value1 === $value2){
                        $verdict = Verdict::good;
                        $points_earned = $assignment[0]->points;

                    }else{
                        $verdict = Verdict::bad;
                        $points_earned = 0;
                    }
                }catch (Exception $e){
                    $verdict = Verdict::bad;
                    $points_earned = 0;
                }
                }else {
                $maximaCommandAnswer = 'expand(solve(' . $equation . ')); ';
                $maximaCommandSolution = 'expand(solve(' . $latexSolution . ')); ';
                $outputAnswer = shell_exec("$maxima_path --very-quiet --batch-string=\"load(solve); $maximaCommandAnswer\"");
                $outputSolution = shell_exec("$maxima_path --very-quiet --batch-string=\"load(solve); $maximaCommandSolution\"");
                $lines = explode(PHP_EOL, $outputSolution);

                if (strcmp($outputAnswer, $outputSolution) == 0) {
                    $verdict = Verdict::good;
                    $points_earned = $assignment[0]->points;
                } else {
                    $verdict = Verdict::bad;
                    $points_earned = 0;
                }

                if ($answer == $assignment[0]->solution) {
                    $verdict = Verdict::good;
                    $points_earned = $assignment[0]->points;
                }

                foreach (array_reverse($lines) as $line) {
                    if (strpos($line, 'solve(') !== false) {
                        $solveLineFound = true;
                        $result = substr($line, strpos($line, 'solve('));
                        break;
                    }
                }
            }

            DB::table('assignments')
                ->where('id', $assignment_id)
                ->update([
                    'answer' => $answer,
                    'verdict' => $verdict,
                    'points_earned' => $points_earned,
                    'status' => Status::submitted,
                    //'updated_at' => now(),
                ]);

            return redirect()->back()->with('message', 'Úloha bola odoslaná.');
        }

    function latexToMaxima($latexExpression)
    {
        // Mapping rules for LaTeX to Maxima conversion
        $mappingRules = [

            '/\\\\dfrac{([^{}]+)}{([^{}]+)}/' => '($1) / ($2)',  // DFraction
            '/\\\\frac{([^{}]+)}{([^{}]+)}/' => '($1) / ($2)',  // Fraction
            '/\\\\sqrt{([^{}]+)}/' => 'sqrt($1)',  // Square root
            '/\\\\sin{([^{}]+)}/' => 'sin($1)',  // Sine function
            '/\\\\cos{([^{}]+)}/' => 'cos($1)',  // Cosine function
            '/\)\s*([a-zA-Z]+)/' => ') * \1',  // Implicit multiplication
            '/(\d+)\s*([a-z]+)/' => '\1*\2', // Implicit multiplication
            '/\\{/' => '(',  // Opening curly brace
            '/\\}/' => ')',  // Closing curly brace
            '/\\e/' => '%e',  // Exponential constant
            '/\\\left\[(.+?)\\\right\]/' => '(\1)',  // Brackets
            '/\\\eta/' => 'eta',
            // Add more mapping rules for other functions or expressions as needed
        ];

        // Apply the mapping rules using regular expressions
        $maximaExpression = preg_replace(array_keys($mappingRules), array_values($mappingRules), $latexExpression);

        return $maximaExpression;
    }
    public function guide(){
        return view('guideStudent');
    }
}
