<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $noAssigments = "No Assigments found";
    $task = "Task";
    $equation = "Equation";
    $solution = "Solution";
    $status = "Status";
    $verdict = "Verdict";
    $answer = "Answer";
    $points = "Points earned";
} else {
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $task = "Úloha";
    $equation = "Rovnica";
    $solution = "Výsledok";
    $status = "Stav";
    $verdict = "Verdikt";
    $answer = "Odpoved";
    $points = "Získané body";
}
?>
<x-layout>
    <div class="container">
        @if ($assignments->count() == 0)
            <h2>{{$noAssigments}}</h2>
        @else
            <h2>{{$assignments->first()->first_name}} {{$assignments->first()->last_name}}</h2>
            <table id="tableStudent" class="table display table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ $task }}</th>
                    <th>{{ $equation }}</th>
                    <th>{{ $solution }}</th>
                    <th>{{ $status }}</th>
                    <th>{{ $verdict }}</th>
                    <th>{{ $answer }}</th>
                    <th>{{ $points }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td>{{$assignment->id}}</td>
                        <td> {{$assignment->first_name}}</td>
                        <td> {{$assignment->last_name}}</td>
                        <td> {{$assignment->task}}</td>
                        <td> {{$assignment->equation}}</td>
                        <td> {{$assignment->solution}}</td>
                        <td> {{$assignment->status}}</td>
                        <td> {{$assignment->verdict}}</td>
                        <td> {{$assignment->answer}}</td>
                        <td> {{$assignment->points_earned}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    <script>
        $(document).ready(function () {
            $('#tableStudent').DataTable({
                columnDefs: [{
                    targets: [5],
                    orderData: [5, 4, 3],
                },],
                responsive: true
            });
        });
    </script>
    @endif
</x-layout>
