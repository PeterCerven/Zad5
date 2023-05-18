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
    $show = "Show";
    $filter = "Search";
    $norecords = "No records";
    $records = "from";
    $showing = "Showing";
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
    $show = "Zobraz";
    $filter = "Hľadaj";
    $norecords = "Žiadny záznam";
    $records = "z";
    $showing = "Zobrazujem";
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
            <table id="tableStudent" class="table display table-striped table-bordered table-condensed">
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

    <div class="container d-flex justify-content-center align-items-center" >
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
                "language": {
                    "lengthMenu": "<?php echo $show; ?> _MENU_"
                },
                oLanguage:{
                    "sSearch": "<?php echo $filter; ?>",
                    "sInfo": "<?php echo $showing; ?> _PAGE_ / _PAGES_",
                    "sInfoFiltered": " <?php echo $records; ?> _MAX_",
                    "sInfoEmpty": "<?php echo $norecords; ?>",
                    "sZeroRecords": "<?php echo $norecords; ?>",
                    "oPaginate": {
                        "sFirst": "Prvá",
                        "sLast": "Posledná",
                        "sNext": ">>",
                        "sPrevious": "<<"
                    }
                },
                initComplete: function () {
                    $('.dataTables_filter input[type="search"]').css({ 'width': '140px', 'display': 'inline-block','margin-left': '10px' });
                    $('.dataTables_length select').css({'display': 'inline-block','width': '60px','margin-left': '10px', 'margin-right': '10px' });
                },
                responsive: true
            });
        });
    </script>
    @endif
</x-layout>
