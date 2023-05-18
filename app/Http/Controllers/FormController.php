<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Writer;
class FormController extends Controller
{
    public static function processForm(Request $request)
    {
        if ($request->input('slovak')==="true") {
            $request->session()->put('language', 'slovak');

        }
        if ($request->input('english')=="true") {
            $request->session()->put('language', 'english');
        }
        return redirect()->back();
    }



    public function generateCSV(Request $request)
    {
        $assignmentsJson = $request->input('assignments');
        $assignments = json_decode($assignmentsJson);
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        // Nastavenie oddelovača stĺpcov
        try {
            $csv->setDelimiter(';');
        } catch (InvalidArgument $e) {
        }
        $csv->setOutputBOM(Writer::BOM_UTF8); // Nastavenie výstupného jazyka na angličtinu (English)

        // Insert headers
        $csv->insertOne(['id', 'first_name', 'last_name', 'task', 'equation', 'solution', 'status', 'verdict', 'answer', 'points_earned']);
        // Vloženie riadkov do CSV
        foreach ($assignments as $row) {
            $csv->insertOne([
                $row->id,
                $row->first_name,
                $row->last_name,
                $row->task,
                $row->equation,
                $row->solution,
                $row->status,
                $row->verdict,
                $row->answer,
                $row->points_earned,
            ]);
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="output.csv"');
        $csv->output();
    }


    public function generateMainCSV(Request $request)
    {
        $usersJson = $request->input('users');
        $users = json_decode($usersJson);
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        // Nastavenie oddelovača stĺpcov
        try {
            $csv->setDelimiter(';');
        } catch (InvalidArgument $e) {
        }
        $csv->setOutputBOM(Writer::BOM_UTF8); // Nastavenie výstupného jazyka na angličtinu (English)

        // Insert headers
        $csv->insertOne(['id', 'name', 'surname', 'assignment_count', 'total_points']);

        // Vloženie riadkov do CSV
        foreach ($users as $row) {
            $csv->insertOne([
                $row->id,
                $row->name,
                $row->surname,
                $row->assignment_count,
                $row->total_points,

            ]);
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="main_output.csv"');
        $csv->output();
    }
}
