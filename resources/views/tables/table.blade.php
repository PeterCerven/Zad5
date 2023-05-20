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
    $exercises = "Generated exercises";
    $submittedExercises = "Submitted exercises";
    $points = "Earned Points";
    $csv = "Get CSV";
    $show = "Show";
    $filter = "Search";
    $norecords = "No records";
    $records = "from";
    $showing = "Showing";
    $exercises = "Exercises";
} else {
    $name = "Meno";
    $Surname = "Priezvisko";
    $exercises = "Generované úlohy";
    $submittedExercises = "Odoslané úlohy";
    $points = "Získané body";
    $csv = "Generuj CSV";
    $show = "Zobraz";
    $filter = "Hľadaj";
    $norecords = "Žiadny záznam";
    $records = "z";
    $showing = "Zobrazujem";
    $exercises = "Úlohy";
}


$table = implode(";", array("ID",$name,$Surname, $exercises, $submittedExercises, $points));

$usersArray = [];
foreach ($users as $user) {
    $usersArray[] = (array)$user;
}
$usersJson = json_encode($usersArray);
?>
<x-layout>
    <div class="container d-flex justify-content-center align-items-center">
        <form action="{{ route('generate.main.csv') }}" method="POST">
            <input type="hidden" name="users" value="{{ $usersJson }}">
            <input type="hidden" name="table" value="{{ $table }}">
            @csrf
            <button class="bg-black text-white rounded py-2 px-4 hover:bg-black" type="submit">{{$csv}}</button>
        </form>
    </div>
    <div class="container">
        @if($users)
            <table id="table" class="table display table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ $name }}</th>
                    <th>{{ $Surname }}</th>
                    <th>{{ $exercises }}</th>
                    <th>{{ $submittedExercises }}</th>
                    <th>{{ $points }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>
                            <button class='btn btn-primary'>
                                <a class='text-decoration-none text-white'
                                   href='/table/{{$user->id}}'>{{$user->name}}</a>
                            </button>
                        </td>
                        <td> {{$user->surname}}</td>
                        <td> {{$user->assignment_count}}</td>
                        <td> {{$user->assignment_submitted}}</td>
                        <td> {{$user->total_points}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                columnDefs: [
                    {
                        targets: [5],
                        orderData: [5, 2],
                    },
                    {
                        targets: [4],
                        orderData: [4, 2],
                    },
                    {
                        targets: [3],
                        orderData: [3, 2],
                    },
                ],
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
