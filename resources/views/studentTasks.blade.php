<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $aTasks = "Assigned tasks";
    $mPoints = "Max. Points";
    $noAssigments = "No Assigments found";
    $points = "Given points";
    $from = "From";
    $to = "To";
    $answer = "Answer";
    $status = "Status";
    $stassignments = "Assignment";
    $section = "Section";
    $oAssigments = "Open assigment";
} else {
    $aTasks = "Pridelené úlohy";
    $mPoints = "Max. bodov";
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $points = "Body";
    $from = "Od";
    $to = "Do";
    $answer = "Odpoved";
    $status = "Stav";
    $stassignments = "Pridelenie";
    $section = "Sekcia";
    $oAssigments = "Otvor pridelenie";
}
?>
<x-layout>
    <div class="container mt-5">
        <div class="align-items-center justify-content-center">

            @if(count($assignments) == 0)
                <p>{{$noAssigments}}</p>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

            @else
                <h1>{{$aTasks}}</h1>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">{{$mPoints}}</th>
                        <th scope="col">{{$section}}</th>
                        <th scope="col">{{$stassignments}}</th>
                        <th scope="col">{{$points}}</th>
                        <th scope="col">{{$from}}</th>
                        <th scope="col">{{$to}}</th>
                        <th scope="col">{{$status}}</th>
                        <th scope="col">{{$answer}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->points }}</td>
                            <td>{{ $assignment->section }}</td>
                            <td>{{ $assignment->task }}</td>
                            <td>{{$assignment->points_earned}}</td>
                            <td>{{ $assignment->from }}</td>
                            <td>{{ $assignment->to }}</td>
                            <td>{{ $assignment->status }}</td>
                            <td>
                                <form method="get" action="{{ url('student/showTask', $assignment->id) }}">
                                    <button type="submit">{{$oAssigments}}</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>




            @endif





        </div>
        <div class="side">

        </div>
    </div>
</x-layout>
