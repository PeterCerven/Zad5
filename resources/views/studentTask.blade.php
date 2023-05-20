<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $tasks = "Task";
    $equation = "Equation";
    $noAssigments = "No Assigments found";
    $points = "Points";
    $sub = "Submit";
    $submited = "Task already submitted";
    $noTask = "No task selected";
    $enterT = "Enter_text";
} else {
    $tasks = "Úloha";
    $equation = "Rovnica";
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $points = "Body";
    $sub = "Predložiť";
    $submited = "Úloha už predložená";
    $noTask = "Žiadna selekovaná úloha";
    $enterT = "Zadaj_text";
}
?>
<x-layout>
    <div class="container mt-5">
        <div class="align-items-center justify-content-center">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.4.4/math.js"></script>
            <script>
                // Your Math.js code here
                // You can use the Math.js library functions and methods in this script block
            </script>

            @if($assignment!=null)
                <div class="container">
                    <div class="row row-cols-2">
                        <div class="col">
                            <h1 class="text-xl" style="font-weight: bold">{{$tasks}}  {{$assignment[0]->section}}</h1>
                            <p class="text-lg">{{$tasks}}: {{$assignment[0]->task}}</p>
                            <p class="text-lg">{{$equation}}: <?php echo '\(' . $assignment[0]->equation . '\)'; ?></p>
                        </div>
                        <div class="col">
                            @if ($assignment[0]->image_name!='')
                                <img src="{{ asset('latex/images/'.$assignment[0]->image_name) }}" alt="Image">
                            @endif
                        </div>
                    </div>
                </div>

                    <form method="get" action="{{ url('student/submitTask', $assignment[0]->id) }}">
                        <div class="form-group">


                            <textarea @if($assignment[0]->status==\App\Enums\Status::submitted)
                                        disabled
                                          @endif{{-- Textarea content musi byt v jednom riadku inak to tam hadze whitespaces--}}
                                      class="form-control form-control-lg" placeholder={{$enterT}} rows="5" name="answer">@if ($assignment[0]->answer != null){{$assignment[0]->answer}}@endif</textarea>
                        </div>


                    <div class="row">
                        <div class="col">
                            @if($assignment[0]->status != \App\Enums\Status::submitted)
                                <button class="btn btn-dark btn-lg my-3" type="submit">{{$sub}}</button>
                            @else
                                <button class="my-3 btn btn-dark btn-lg" disabled>{{$submited}}</button>
                            @endif
                        </div>
                        <div class="col text-right my-3 fs-3">
                            <p>{{$points}}: {{$assignment[0]->points_earned}}/{{$assignment[0]->points}}</p>
                        </div>
                    </div>

                </form>





            @else{
        <h2>{{$noTask}}</h2>
                }
            @endif











        </div>
        <div class="side">

        </div>
    </div>
</x-layout>
