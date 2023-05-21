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
    $enterT = "Anwer";
} else {
    $tasks = "Úloha";
    $equation = "Rovnica";
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $points = "Body";
    $sub = "Predložiť";
    $submited = "Úloha už predložená";
    $noTask = "Žiadna selekovaná úloha";
    $enterT = "Odpoveď";
}

//<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.4.4/math.js"></script>
//
//<link rel="stylesheet" href="/resources/mathquill-0.10.1/mathquill-basic.css">
//<script src="/resources/mathquill-0.10.1/mathquill.min.js"></script>
//<script src="/resources/mathquill-0.10.1/mathquill-basic.js"></script>
 //           <script src="/resources/mathquill-0.10.1/mathquill.test.js"></script>
//
?>


<x-layout>
    <div class="container mt-5">
        <div class="align-items-center justify-content-center">



            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    var mathFieldSpan = document.getElementById('math-field');
                    var latexSpan = document.getElementById('latex');
                    var latexInput = document.getElementById('latex-input');

                    var MQ = MathQuill.getInterface(2); // for backcompat
                    var mathField = MQ.MathField(mathFieldSpan, {
                        spaceBehavesLikeTab: true, // configurable
                        handlers: {
                            edit: function() { // useful event handlers
                                latexSpan.textContent = mathField.latex(); // simple API
                                latexInput.value = mathField.latex(); // simple API
                            }
                        }
                    });
                });
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


                        <div class="form-group">
                            <form method="get" action="{{ url('student/submitTask', $assignment[0]->id) }}">
                            <p>LaTeX of what you typed: <span id="latex"></span></p>
                                <input type="text" hidden="hidden" id="latex-input" name="answer">

                            @if($assignment[0]->status==\App\Enums\Status::taken)
                                    <span style="width: 600px; height: 100px; font-size: 25px" id="math-field"></span>
                            @else
                                <textarea disabled rows="5" class="form-control form-control-lg" placeholder={{$enterT}}   >@if ($assignment[0]->answer != null){{$assignment[0]->answer}}@endif</textarea>
                            @endif{{-- Textarea content musi byt v jednom riadku inak to tam hadze whitespaces--}}






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
