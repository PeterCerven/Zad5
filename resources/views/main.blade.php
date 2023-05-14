
<?php
/*
$v1 = '\frac{4s^2+2}{2s^3+40s+4}';
$v2 = '\frac{2s^2+1}{s^3+20s+2}';
if (PHP_OS === 'WINNT') {
$maxima_path = "C:/Mato/maxima-5.46.0/bin/maxima.bat";
} else {
$maxima_path = "/usr/bin/maxima";
}
//$expression = "(4*x^2 + 2)/(2*x^2 + 40*x + 4) = (2*x^2 + 1)/(x^2 + 20*x + 2)";
//$expression = "(4*x^2 + 2)/(2*x^2 + 40*x + 4) - (2*x^2 + 1)/(x^2 + 20*x + 2)";
$expression = "(3/2 - 3/2*exp(-2/5*(t-4)) - 3/5*(t-4)*exp(-2/5*(t-4))) = (3/2 - 3/2*exp(-2/5*(t-4)) - 3/5*(t-4)*exp(-2/5*(t-4)))";
//$output = shell_exec("$maxima_path --batch-string=\"load(solve); solve($expression);\"");
$e1 = "(3/2 - 3/2*exp(-2/5*(t-4)) - 3/5*(t-4)*exp(-2/5*(t-4)))";
$e2 = "(3/2 - 3/2*exp(-4/10*(t-4)) - 3/5*(t-4)*exp(-2/5*(t-4)))";
$command = "$maxima_path -q  --batch-string=\"is(equal($e1, $e2));\" 2>&1";
$output = shell_exec($command);
//echo $output;

//$output = shell_exec("$maxima_path --nostrip --batch-string=\"load(solve); is(equal($e1, $e1));\"");
//$output = shell_exec("$maxima_path --batch-string=\"load(solve); is($expression);\"");
//$output = shell_exec('maxima --very-quiet --batch-string "load(solve); eq1: ' . $v1 . '; eq2: ' . $v2 . '; is(eq1 = eq2);"');
//$output = shell_exec('maxima --very-quiet --batch-string "load(solve); is((4*x^2 + 2)/(2*x^2 + 40*x + 4) = 2/(x^3 + 20*x + 2)); "');
//$output = shell_exec('maxima -q test.mac');
//$output = shell_exec('maxima');
//$aaa =is((4*x^2 + 2)/(2*x^2 + 40*x + 4) = 2/(x^3 + 20*x + 2));
$substring="";
$index = strpos($output, "(%o2)"); // Zistíme index začiatku "(%o2)" v reťazci
if ($index !== false) { // Ak sa "(%o2)" v reťazci nachádza
$substring = substr($output, $index + 6); // Vytvoríme nový reťazec obsahujúci časť za "(%o2)"
//echo $substring; // Vypíšeme nový reťazec
} else {
//echo "Retazec \"(%o2)\" sa v retazci nenachadza.";
}
//var_dump(trim($output));
echo "\n";
//$expression = "(4*x^2 + 2)/(2*x^2 + 40*x + 4) - (2*x^2 + 1)/(x^2 + 20*x + 2)";
$expression = "(3/2 - 3/2*exp(-2/5*(t-4)) - 3/5*(t-4)*exp(-2/5*(t-4))) = (3/2 - 3/2*exp(-2/5*(t-4)) - 3/5*(t-4)*exp(-2/5*(t-4)))";
$output = shell_exec("$maxima_path --batch-string=\"load(solve); algsys([$expression],[x]);\"");
$index = strpos($output, "(%o2)"); // Zistíme index začiatku "(%o2)" v reťazci
if ($index !== false) { // Ak sa "(%o2)" v reťazci nachádza
$substring = substr($output, $index + 6); // Vytvoríme nový reťazec obsahujúci časť za "(%o2)"
//echo $substring; // Vypíšeme nový reťazec
} else {
//echo "Retazec \"(%o2)\" sa v retazci nenachadza.";
}
//(%o2)
//var_dump(trim($substring));
*/
?>


<x-layout>
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-center">
            <div class="mb-6">
                <a href="/teacher" class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                    Go to teacher's page
                </a>
            </div>
            <div class="mb-6">
                <a href="/student" class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                    Go to student's page
                </a>
            </div>
        </div>
    </div>

</x-layout>

