<?php
use App\Http\Controllers\DBController;
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
DBController::workWithLatexFiles();
if ($en){
    $welcome  = "Welcome";
    $action = "Action";
    $logout = "Logout";
    $login = "Login";

} else {
    $welcome  = "Vitaj";
    $action = "Akcia";
    $logout = "Odhlásenie";
    $login = "Prihlásenie";
}


$input="\dfrac{5s+32}{10s^2+45s+32}";

// Hľadanie obsahu prvej zátvorky
$patternA = '/\\\\d?frac{([^{}]+)}{[^{}]+}/';
preg_match($patternA, $input, $matches);
$first = $matches[1];
var_dump($input);
echo "<br>";

// Hľadanie obsahu druhej zátvorky
$patternB = '/\\\\d?frac{[^{}]+}{([^{}]+)}/';
preg_match($patternB, $input, $matches);
$second  = $matches[1];
$result1 = '('.$first.')'.'/'.'('.$second.')';
$result1 = str_replace('s', '*s', $result1);
echo "<br>";
var_dump($result1);
echo "<br>";


$input="\dfrac{10s+64}{20s^2+90s+64}";

// Hľadanie obsahu prvej zátvorky
$patternA = '/\\\\d?frac{([^{}]+)}{[^{}]+}/';
preg_match($patternA, $input, $matches);
$first = $matches[1];
var_dump($input);
echo "<br>";

// Hľadanie obsahu druhej zátvorky
$patternB = '/\\\\d?frac{[^{}]+}{([^{}]+)}/';
preg_match($patternB, $input, $matches);
$second  = $matches[1];
$result2 = '('.$first.')'.'/'.'('.$second.')';
$result2 = str_replace('s', '*s', $result2);
echo "<br>";
var_dump($result2);
echo "<br>";


if (PHP_OS === 'WINNT') {
    $maxima_path = "C:/Mato/maxima-5.46.0/bin/maxima.bat";
} else {
    $maxima_path = "/usr/bin/maxima";
}

$command = "$maxima_path -q  --batch-string=\"is(equal($result1, $result2));\" 2>&1";
$output = shell_exec($command);
echo $output;

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


//(4*x^2 + 2)/(2*x^2 + 40*x + 4) = (2*x^2 + 1)/(x^2 + 20*x + 2)
$equationFromDatabase = "y^{'''}(t)+8y^{''}(t)+19y^{'}(t)+12y(t)=u(t)";
$initialConditions = '$y(0)=-1$, $y^{\'}(0)=0$ a $y^{\'\'}(0)=4$.';
?>
    <!DOCTYPE html>
<html lang="sk">
<head>
    <style>
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 3rem;
            background-color: #0a4275;
            box-shadow:1px 1px 10px rgba(0,0,0,0.5);
        }
        .copyright {
            color: white;
            text-align: center;
            font-size: medium;
            margin-top: 12px;
            text-shadow: 2px 2px 5px #000000;
        }
    </style>
    <meta charset="UTF-8">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Pre zobrazenie rovnic -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script>
        MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']]
            }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" async
            src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
    </script>
    <title>
        <?php if ($en) {
            echo "Latex";
        } else {
            echo "Latex";
        } ?>
    </title>
</head>
<body>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="bootstrap" viewBox="0 0 118 94">
        <title>Bootstrap</title>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
    </symbol>
    <symbol id="facebook" viewBox="0 0 16 16">
        <path
            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
    </symbol>
    <symbol id="instagram" viewBox="0 0 16 16">
        <path
            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
    </symbol>
    <symbol id="twitter" viewBox="0 0 16 16">
        <path
            d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
    </symbol>
</svg>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0a4275; box-shadow:1px 1px 10px rgba(0,0,0,0.5);" aria-label="Mynavigator">
        <div class="container">
            <a class="navbar-brand font-bold" href="/"><?php if ($en) {
                    echo "Navigation";
                } else {
                    echo "Navigácia";
                } ?></a>
            <div class="font-bold position-absolute end-20 ">
                @php
                    $currentUrl = url()->current();
                @endphp
                @switch($currentUrl)
                    @case(Str::contains($currentUrl, 'http://zad5.test/student/showTasks'))
                        <a href="{{ url('http://zad5.test/student') }}" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                        @break

                    @case(Str::contains($currentUrl, 'http://zad5.test/student/showTask'))
                        <a href="{{ url('http://zad5.test/student/showTasks') }}" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                        @break

                    @case(Str::contains($currentUrl, 'http://zad5.test/student'))
                        <a href="{{ url('http://zad5.test') }}" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                        @break

                    @case(Str::contains($currentUrl, 'http://zad5.test/table/'))
                        <a href="{{ url('http://zad5.test/table') }}" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                        @break

                    @case(Str::contains($currentUrl, 'http://zad5.test/table'))
                        <a href="{{ url('http://zad5.test/teacher') }}" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                        @break

                    @case(Str::contains($currentUrl, 'http://zad5.test/teacher'))
                        <a href="{{ url('http://zad5.test') }}" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                        @break

                    @default
                        <a href="javascript:void(0);" class="hover:text-laravel" style="color: white">
                            <i class="fa-solid fa-arrow-left" style="color: white"></i>
                            {{ $en ? "Back" : "Späť" }}
                        </a>
                @endswitch
            </div>
            <div class="position-absolute mt-4 end-6">
                <?php if (session('language') == "english"){ ?>
                <form action="{{ route('form.process') }}" method="post">
                    @csrf
                    <label for="slovak">
                    </label>
                    <input class="collapse" type="text" size="10" value="true" name="slovak" id="slovak">
                    <button type="submit" class="flag bg-primary" data-lang="sk"><img
                            src="{{ asset('pics/sk_flag.png') }}" alt="Slovak" width="30" height="15"></button>
                </form>

                <?php } ?>
                <?php if (session('language') == "slovak"){ ?>
                <form action="{{ route('form.process') }}" method="post">
                    @csrf
                    <label for="english">
                    </label>
                    <input class="collapse" type="text" size="10" value="true" name="english" id="english">
                    <button type="submit" class="flag bg-primary" data-lang="en"><img
                            src="{{ asset('pics/gb_flag.png') }}" alt="English" width="30" height="15"></button>
                    <div id="language-switcher" class="d-flex flex-row-reverse bg-primary">
                    </div>
                    <div class="d-flex bg-secondary">
                    </div>
                </form>
                <?php } ?>
            </div>

            <div class="container">
                <ul>
                    @auth
                        <li>
                    <span class="font-bold uppercase" style="color: white">
                        {{$welcome." ".auth()->user()->name}}
                    </span>
                        </li>
                        <li style="color: white">
                            <a href="/guide" style="text-decoration: none; color: white;">
                                <i class="fa-solid fa-question" style="color: white"></i>
                                {{ $en ? "Guide" : "Návod" }}
                            </a>
                        </li>
                        <li>
                            <form class="inline" method="POST" action="/logout" style="color: white">
                                @csrf
                                <button type="submit" class="hover:text-laravel">
                                    <i class="fa-solid fa-door-closed" style="color: white"></i>
                                    {{$logout}}
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="/login" class="hover:text-laravel" style="color: white">
                                <i class="fa-solid fa-arrow-right-to-bracket" style="color: white"></i>
                                {{$login}}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

{{$slot}}

<footer class="footer mt-auto">
    <p class="copyright">&copy; 2023 Peter Červeň, Andrej Király, Martin Jucha a Martin Bugoš</p>
</footer>
<script type="text/javascript"></script>
</body>
</html>
