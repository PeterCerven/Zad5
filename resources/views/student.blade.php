<x-layout>
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-center">
            <form method="get" action="/student/generateNewTask">
                <button
                    class="btn btn-success"
                    type="submit">
                    Generuj novú úlohu
                </button>

            </form>
            <form method="get" action="/student/showTasks">
                <button
                    class="btn btn-success"
                    type="submit">
                    Zobraz úlohy
                </button>
            </form>

            @if($generatedAssignment==null)
                <p>no assigments</p>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            @else


                    <p>ID: {{ $generatedAssignment->id }}</p>
                    <p>Points: {{ $generatedAssignment->points }}</p>
                    <p>From: {{ $generatedAssignment->from }}</p>
                    <p>To: {{ $generatedAssignment->to }}</p>





            @endif







        </div>
    </div>
        <div class="side">
    </div>



</x-layout>
