<?php

if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $name = "Name";
    $Surname = "Surname";
    $noAssigments = "No Assigments found";
    $task = "Task";
    $equation = "Equation";
    $solution = "Solution";
    $status = "Status";
    $verdict = "Verdict";
    $answer = "Answer";
    $points = "Points earned";
    $csv = "Get CSV";
    $back = "Back";
} else {
    $name = "Meno";
    $Surname = "Priezvisko";
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $task = "Úloha";
    $equation = "Rovnica";
    $solution = "Výsledok";
    $status = "Stav";
    $verdict = "Verdikt";
    $answer = "Odpoved";
    $points = "Získané body";
    $csv = "Generuj CSV";
    $back = "Späť";
}
$assignmentsArray = [];
foreach ($assignments as $assignment) {
    $assignmentsArray[] = (array) $assignment;
}
$assignmentsJson = json_encode($assignmentsArray);
?>
<x-layout>
    <div class="container">
        @if ($assignments->count() == 0)
            <h2>{{$noAssigments}}</h2>
        @else
            <h2>{{$assignments->first()->first_name}} {{$assignments->first()->last_name}}</h2>
            <table id="tableStudent" class="table display table-striped table-bordered table-condensed" style="margin: 10px">
                <thead>
                <tr>
                    <th class="d-none">ID</th>
                    <th class="d-none">{{ $name }}</th>
                    <th class="d-none">{{ $Surname }}</th>
                    <th class="maxwidth">{{ $task }}</th>
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
                        <td class="d-none">{{$assignment->id}}</td>
                        <td class="d-none"> {{$assignment->first_name}}</td>
                        <td class="d-none"> {{$assignment->last_name}}</td>
                        <td class="maxwidth"> {{$assignment->task}}</td>
                        <td> <?php echo '\(' . $assignment->equation . '\)'; ?></td>
                        <td> <?php echo '\(' . $assignment->solution . '\)'; ?></td>

                        <td> {{$assignment->status}}</td>
                        <td> {{$assignment->verdict}}</td>
                        <td> {{$assignment->answer}}</td>
                        <td> {{$assignment->points_earned}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>

    <div class="container d-flex justify-content-around align-items-center" >
        <button class="bg-black text-white rounded py-2 px-4 hover:bg-black" type="button">
            <a href="{{ route('teacher.table') }}">{{$back}}</a>
        </button>
        <form action="{{ route('generate.csv') }}" method="POST">
            <input type="hidden" name="assignments" value="{{ $assignmentsJson }}">
            @csrf
            <button class="bg-black text-white rounded py-2 px-4 hover:bg-black" type="submit">{{$csv}}</button>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('#tableStudent').DataTable({
                columnDefs: [
                    {
                    targets: [5],
                    orderData: [5, 4, 3],
                },],
                responsive: true,
                info: false,
                paging: false,
            });
        });
    </script>
    @endif
</x-layout>
