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
    $noAssigments = "No assignments";
    $points = "Points";
    $from = "From";
    $to = "To";
} else {
    $set = "Vygenerovať novú úlohu";
    $show = "Zobraziť úlohy";
    $noAssigments = "Žiadne úlohy";
    $points = "Body";
    $from = "Od";
    $to = "Do";
}
?>
<style>
    .button-blue {
        background-color: #0a4275 !important;
        box-shadow:1px 1px 10px rgba(0,0,0,0.5);
        transition: 0.4s ease;
    }
    .button-blue:hover {
        background-color: #2576C2 !important;
    }
</style>
<x-layout>
    <div class="container mt-20">
        <div class="d-flex align-items-center justify-content-center">
            @if(count($assignments)==0)
                <strong><p>{{$noAssigments}}</p></strong>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            @else
                @if (session('message')&&$points=='Body')
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @elseif (session('message')&&$points=='Points')
                    <div class="alert alert-danger">
                        {{'No more assignments available' }}
                    </div>
                @endif


            @endif
        </div>
        <div class="d-flex align-items-center justify-content-center mt-10">
            <form method="get" action="/student/generateNewTask">
                <button
                    class="button-blue text-white rounded py-2 px-4 me-3"
                    type="submit">
                    {{$set}}
                </button>
            </form>
            <form method="get" action="/student/showTasks">
                <button
                    class="button-blue text-white rounded py-2 px-4"
                    type="submit">
                    {{$show}}
                </button>
            </form>
        </div>
    </div>
</x-layout>
