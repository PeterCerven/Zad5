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
    $noAssigments = "No assignments found";
    $points = "Given points";
    $from = "From";
    $to = "To";
    $answer = "Answer";
    $status = "Status";
    $stassignments = "Assignment";
    $section = "Section";
    $oAssigments = "Open assignment";
} else {
    $aTasks = "Pridelené úlohy";
    $mPoints = "Max. bodov";
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $points = "Body";
    $from = "Od";
    $to = "Do";
    $answer = "Odpoveď";
    $status = "Stav";
    $stassignments = "Pridelenie";
    $section = "Sekcia";
    $oAssigments = "Otvoriť úlohu";
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
                <h1><strong>{{$aTasks}}</strong></h1>
                <table class="table table-bordered mt-3">
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
                            <td>{{ $assignment->points_earned}}</td>
                            <td>{{ $assignment->from }}</td>
                            <td>{{ $assignment->to }}</td>
                            @if($section =='Sekcia')
                                @if( $assignment->status  == 'taken')
                                    <td>{{'Neodovzdané'}}</td>
                                @elseif( $assignment->status  == 'submitted')
                                    <td>{{'Odovzdané'}}</td>
                                @endif
                            @else
                                <td>{{ $assignment->status }}</td>
                            @endif

                            <td>
                                <form method="get" action="{{ route('student.showTask', ["id" => $assignment->id]) }}">
                                    <button class="button-blue text-white rounded py-1 px-2" type="submit">{{$oAssigments}}</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-layout>
