<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\LatexData;

class DBController extends Controller
{
    /*
    private $conn;

    public function __construct()
    {
        $this->conn = DB::connection()->getPdo();
    }
    */
    public static function workWithLatexFiles()
    {
        $dir = public_path('latex');
        $files = scandir($dir);
        foreach ($files as $filename) {
            if (preg_match('/\.tex$/', $filename)) {
                if (!LatexData::isLatexFileInDB($filename)) {
                    $file_path = $dir . DIRECTORY_SEPARATOR . $filename;
                    $file_contents = File::get($file_path);
                    DBController::processSections($filename, $file_contents); // spracovanie a uloženie úlohy do databázy
                }
            }
        }
    }

    static private function processSections($name, $latexCode) {
        $patternSection = '/\\\section\*?\{(.+?)}/';
        $matches = array();
        // Hľadáme prvú sekciu v texte
        if (preg_match($patternSection, $latexCode, $matches, PREG_OFFSET_CAPTURE)) {
            $sectionTitle = $matches[1][0]; // názov sekcie
            $sectionStart = $matches[0][1]; // index začiatku sekcie
            $sectionEnd = strlen($latexCode); // index konca sekcie
            $docEnd = $sectionEnd;
            // Ak sa v texte nachádza ďalšia sekcia, nastavíme koniec aktuálnej sekcie pred začiatkom nasledujúcej
            if (preg_match($patternSection, $latexCode, $matches, PREG_OFFSET_CAPTURE, $sectionStart+10)) {
                $sectionEnd = $matches[0][1];
            }
            $sectionContent = substr($latexCode,$sectionStart , $sectionEnd - $sectionStart);
            //$processedSection = $this->processSection($name, $sectionTitle,$sectionContent);
            DBController::processSection($name, $sectionTitle,$sectionContent);
            // Rekurzívne spracovanie zvyšku textu za aktuálnou sekciou
            $remainingText = substr($latexCode, $sectionEnd, $docEnd - $sectionStart);
            //$processedRemainingText = $this->processSections($name, $remainingText);
            DBController::processSections($name, $remainingText);
            //return $sectionTitle . $processedSection . $processedRemainingText;
        }
        //return $latexCode;
    }
    static private function processSection($name, $sectionTitle, $sectionContent) {
        $section = $sectionTitle;

        // Získanie  textu úlohy
        $pattern_text = '/\\\begin\{task}\s*(.*?)\\\end\{task}/s';
        //$pattern_text = '/\\\begin\{task}\s*(.*?)\\\end\{task}/s';
        preg_match($pattern_text, $sectionContent, $matches);
        $task = trim($matches[1]);
        $substring = '\includegraphics';
        $position = strpos($task, $substring);
        if ($position !== false) {
            trim($task = substr($task, 0, $position));
        }
        $substring = '\begin';
        $position = strpos($task, $substring);
        if ($position !== false) {
            trim($task = substr($task, 0, $position));
        }
        $substring = '\\\\';
        $position = strpos($task, $substring);
        if ($position !== false) {
            trim($task = substr($task, 0, $position));
        }

        // Regulárny výraz pre získanie rovnice
        $pattern_rovnica = '/\\\begin\{equation\*}(.+?)\\\end\{equation\*}/s';
        preg_match($pattern_rovnica, $sectionContent, $matches);
        $equation = trim($matches[1]);

        $pattern_pokec = '/\\\end{equation\*}(.+?)\\\/s';
        preg_match($pattern_pokec, $sectionContent, $matches);
        if (count($matches) > 0) {
            $eq_text = trim($matches[1]);
        } else {
            $eq_text = '';
        }

        $pattern_res = '/\\\begin{solution}\s*\\\begin{equation\*}\s*(.+?)\\\end{equation\*}\s*\\\end{solution}/s';
        preg_match($pattern_res, $sectionContent, $matches);
        $solution = trim($matches[1]);
        if ($solution==$equation){
            $equation =  '';
        }
        // Regulárny výraz pre získanie informácie o začiatočných podmienkach
        $pattern_vztah = '/\\\end\{equation\*}(.*?)\\\end\{task}/s';
        // Získanie informácií o začiatočných podmienkach
        preg_match($pattern_vztah, $sectionContent, $matches);
        $eq_conditions = '';
        if (count($matches) > 0) {
            $tmp = $matches[1];
            $startMarker = '\\';
            $startIndex = strpos($tmp, $startMarker);
            if ($startIndex>0){
                $result = substr($tmp, $startIndex+2);
                $eq_conditions = trim($result);
            }
        }

        // Regulárny výraz pre získanie názvu obrázku
        $pattern_pic = '/\\\includegraphics\{(.+?)}/';
        // Získanie názvu obrázku
        preg_match($pattern_pic, $sectionContent, $matches);
        if (count($matches) > 0) {
            $image_name = $matches[1];
            $pos = strpos($image_name, '/');
            if ($pos !== false) {
                $image_name = substr($image_name, $pos + 1);
            }
        } else {
            $image_name = '';
        }

        $latexData = new LatexData($name,$section, $task, $equation, $eq_text, $solution, $eq_conditions, $image_name);
        DBController::insertLatexData($latexData);
    }

    static private function insertLatexData(LatexData $latexData)
    {
        $latexData->save();
    }
}
