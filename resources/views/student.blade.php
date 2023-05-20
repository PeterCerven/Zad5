<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $set = "Generate a new task";
    $show = "Show task";
    $noAssigments = "no assigments";
    $points = "Points";
    $from = "From";
    $to = "To";
} else {
    $set = "Generuj novú úlohu";
    $show = "Zobraz úlohy";
    $noAssigments = "žiadne úlohy";
    $points = "Body";
    $from = "Od";
    $to = "Do";
}
?>
<x-layout>
    <div class="container mt-20">
        <div class="d-flex align-items-center justify-content-center">
            <form method="get" action="/student/generateNewTask">
                <button
                    class="text-white rounded py-2 px-4 me-3" style="background-color: #0a4275; box-shadow:1px 1px 10px rgba(0,0,0,0.5);"
                    type="submit">
                    {{$set}}
                </button>

            </form>
            <form method="get" action="/student/showTasks">
                <button
                    class="text-white rounded py-2 px-4" style="background-color: #0a4275; box-shadow:1px 1px 10px rgba(0,0,0,0.5);"
                    type="submit">
                    {{$show}}
                </button>
            </form>

            @if($generatedAssignment==null)
                <p>{{$noAssigments}}</p>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            @else


                    <p>ID: {{ $generatedAssignment->id }}</p>
                    <p>{{$points}}: {{ $generatedAssignment->points }}</p>
                    <p>{{$from}}: {{ $generatedAssignment->from }}</p>
                    <p>{{$to}}: {{ $generatedAssignment->to }}</p>





            @endif







        </div>
    </div>
        <div class="side">
    </div>



</x-layout>
