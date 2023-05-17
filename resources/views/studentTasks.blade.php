<x-layout>
    <div class="container mt-5">
        <div class="align-items-center justify-content-center">

            @if(count($assignments) == 0)
                <p>no assigments</p>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

            @else
                <h1>Assigned tasks</h1>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Max. Points</th>
                        <th scope="col">Section</th>
                        <th scope="col">Assignment</th>
                        <th scope="col">Given Points</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Status</th>
                        <th scope="col">Answer</th>
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
                                    <button type="submit">Open Assignment</button>
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
