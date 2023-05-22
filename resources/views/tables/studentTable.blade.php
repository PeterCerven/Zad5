<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en) {
    $name = "Name";
    $Surname = "Surname";
    $noAssigments = "No Assignments found";
    $task = "Task";
    $equation = "Equation";
    $solution = "Solution";
    $status = "Status";
    $verdict = "Verdict";
    $answer = "Answer";
    $points = "Points earned";
    $csv = "Get CSV";
    $show = "Show";
    $filter = "Search";
    $norecords = "No records";
    $records = "from";
    $showing = "Showing";
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
    $answer = "Odpoveď";
    $points = "Získané body";
    $csv = "Generuj CSV";
    $back = "Späť";
    $show = "Zobraz";
    $filter = "Hľadaj";
    $norecords = "Žiadny záznam";
    $records = "z";
    $showing = "Zobrazujem";
}

$table = implode(";", array("ID", $name, $Surname, $task, $equation, $solution, $status, $verdict, $answer, $points));
$assignmentsArray = [];
foreach ($assignments as $assignment) {
    $assignmentsArray[] = (array)$assignment;
}
$assignmentsJson = json_encode($assignmentsArray);
?>
<style>
    .button-blue {
        background-color: #0a4275 !important;
        box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.5);
        transition: 0.4s ease;
    }
    .button-blue:hover {
        background-color: #2576C2 !important;
    }
</style>
<x-layout>
    <div class="container d-flex justify-content-center align-items-center mt-10">
        <form action="{{ route('generate.csv') }}" method="POST">
            @csrf
            <input type="hidden" name="assignments" value="{{ $assignmentsJson }}">
            <input type="hidden" name="table" value="{{ $table }}">
            <button class="button-blue text-white rounded py-2 px-4" type="submit">{{ $csv }}</button>
        </form>
    </div>
    <div class="container mb-20">
        @if ($assignments->count() == 0)
            <h2><strong>{{ $noAssigments }}</strong></h2>
        @else
            <h2><strong>{{ $assignments->first()->first_name }} {{ $assignments->first()->last_name }}</strong></h2>
            <table id="tableStudent" class="table display table-striped table-bordered table-condensed" style="margin: 10px">
                <thead>
                <tr>
                    <th class="d-none">ID</th>
                    <th class="d-none">{{ $name }}</th>
                    <th class="d-none">{{ $Surname }}</th>
                    <th class="maxwidth">{{ $task }}</th>
                    <th>{{ $equation }}</th>
                    <th>{{ $solution }}</th>
                    @if($name =='Meno')
                        @if( $assignment->status  == 'taken')
                            <th>{{'Stav'}}</th>
                            <th>{{'Verdikt'}}</th>
                        @elseif( $assignment->status  == 'submitted')
                            <th>{{'Stav'}}</th>
                            <th>{{'Verdikt'}}</th>
                        @endif
                    @else
                        <th>{{ $assignment->status }}</th>
                        <th>{{ $verdict }}</th>
                    @endif

                    <th>{{ $answer }}</th>
                    <th>{{ $points }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td class="d-none">{{ $assignment->id }}</td>
                        <td class="d-none">{{ $assignment->first_name }}</td>
                        <td class="d-none">{{ $assignment->last_name }}</td>
                        <td class="maxwidth">{{ $assignment->task }}</td>
                        <td>{{ '\(' . $assignment->equation . '\)' }}</td>
                        <td>{{ '\(' . $assignment->solution . '\)' }}</td>
                        @if($name =='Meno')
                            @if( $assignment->status  == 'taken')
                                <td>{{'Neodovzdané'}}</td>
                                <td>{{'Neprospel'}}</td>
                            @elseif( $assignment->status  == 'submitted')
                                <td>{{'Odovzdané'}}</td>
                                <td>{{'Prospel'}}</td>
                            @endif
                        @else
                            <td>{{ $assignment->status }}</td>
                            <th>{{ $assignment->verdict }}</th>
                        @endif
                        <td>{{ $assignment->answer }}</td>
                        <td>{{ $assignment->points_earned }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <script>
        $(document).ready(function () {
            $('#tableStudent').DataTable({
                columnDefs: [
                    {
                        targets: [5],
                        orderData: [5, 4, 3],
                    },
                ],
                "language": {
                    "lengthMenu": "{{ $show }} _MENU_"
                },
                "oLanguage": {
                    "sSearch": "{{ $filter }}",
                    "sInfo": "{{ $showing }} _PAGE_ / _PAGES_",
                    "sInfoFiltered": " {{ $records }} _MAX_",
                    "sInfoEmpty": "{{ $norecords }}",
                    "sZeroRecords": "{{ $norecords }}",
                    "oPaginate": {
                        "sFirst": "Prvá",
                        "sLast": "Posledná",
                        "sNext": ">>",
                        "sPrevious": "<<"
                    }
                },
                initComplete: function () {
                    $('.dataTables_filter input[type="search"]').css({
                        'width': '140px',
                        'display': 'inline-block',
                        'margin-left': '10px'
                    });
                    $('.dataTables_length select').css({
                        'display': 'inline-block',
                        'width': '60px',
                        'margin-left': '10px',
                        'margin-right': '10px'
                    });
                },
                responsive: true
            });
        });
    </script>
</x-layout>
