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
    $exercises = "Generated exercises";
    $submittedExercises = "Submitted exercises";
    $points = "Earned Points";
    $csv = "Get CSV";
} else {
    $name = "Meno";
    $Surname = "Priezvisko";
    $exercises = "Generované úlohy";
    $submittedExercises = "Odoslané úlohy";
    $points = "Získané body";
    $csv = "Generuj CSV";
}
$usersArray = [];
foreach ($users as $user) {
    $usersArray[] = (array) $user;
}
$usersJson = json_encode($usersArray);
?>
<x-layout>
    <div class="container d-flex justify-content-center align-items-center">
        <form action="{{ route('generate.main.csv') }}" method="POST">
            <input type="hidden" name="users" value="{{ $usersJson }}">
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
