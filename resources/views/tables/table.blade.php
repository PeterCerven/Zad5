<x-layout>
    <div class="container">
        @if($users)
            <table id="table" class="table display table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Generated exercises</th>
                    <th>Earned Points</th>
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
            // $('#top10_data').DataTable({
            //     responsive: true,
            //     paging: false,
            //     info: false
            // });


        });
    </script>
    @endif
</x-layout>
