<x-layout>
    <div class="container">
        @if ($assignments->count() == 0)
            <h2>No Assigments found</h2>
        @else
            <h2>{{$assignments->first()->first_name}} {{$assignments->first()->last_name}}</h2>
            <table id="tableStudent" class="table display table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Equation</th>
                    <th>Solution</th>
                    <th>Status</th>
                    <th>Verdict</th>
                    <th>Answer</th>
                    <th>Points earned</th>
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
