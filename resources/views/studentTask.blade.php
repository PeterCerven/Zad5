<x-layout>
    <div class="container mt-5">
        <div class="align-items-center justify-content-center">


            @if($assignment!=null)
                <h1>Task  {{$assignment[0]->section}}</h1>
                <p class="text-lg">{{$assignment[0]->task}}</p>

                    <form method="get" action="{{ url('student/submitTask', $assignment[0]->id) }}">
                        <div class="form-group">


                            <textarea @if($assignment[0]->status==\App\Enums\Status::submitted)
                                        disabled
                                          @endif{{-- Textarea content musi byt v jednom riadku inak to tam hadze whitespaces--}}
                                      class="form-control form-control-lg" placeholder="Enter text" rows="5" name="answer">@if ($assignment[0]->answer != null){{$assignment[0]->answer}}@endif</textarea>
                        </div>


                    <div class="row">
                        <div class="col">
                            @if($assignment[0]->status != \App\Enums\Status::submitted)
                                <button class="btn btn-dark btn-lg my-3" type="submit">Submit</button>
                            @else
                                <button class="my-3 btn btn-dark btn-lg" disabled>Task already submitted</button>
                            @endif
                        </div>
                        <div class="col text-right my-3 fs-3">
                            <p>Points: {{$assignment[0]->points_earned}}/{{$assignment[0]->points}}</p>
                        </div>
                    </div>

                </form>





            @else{
        <h2>No task selected</h2>
                }
            @endif











        </div>
        <div class="side">

        </div>
    </div>
</x-layout>
