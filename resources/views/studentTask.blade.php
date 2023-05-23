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
    $noAssigments = "No Assignments found";
    $points = "Points";
    $sub = "Submit";
    $submited = "Task already submitted";
    $noTask = "No task selected";
    $enterT = "Answer";
} else {
    $tasks = "Úloha";
    $equation = "Rovnica";
    $noAssigments = "Neboli nájdené žiadne úlohy";
    $points = "Body";
    $sub = "Odovzdať";
    $submited = "Úloha už odovzdaná";
    $noTask = "Žiadna vybraná úloha";
    $enterT = "Odpoveď";
}
?>
<style>
    .button-blue {
        background-color: #0a4275 !important;
        box-shadow:1px 1px 10px rgba(0,0,0,0.5);
        transition: 0.4s ease;
    }
    .button-blue:hover {
        background-color: #2576C2 !important;
    }
</style>
<x-layout>
    <div class="container mt-5">
        <div class="align-items-center justify-content-center">
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    output = document.getElementById('Output');


                    const latexEquation = '\\frac{2s^2+13s+10}{s^3+7s^2+18s+15}';
                    var mathFieldSpan = document.getElementById('math-field');

                    var latexInput = document.getElementById('latex-input');

                    var MQ = MathQuill.getInterface(2); // for backcompat
                    var mathField = MQ.MathField(mathFieldSpan, {
                        spaceBehavesLikeTab: true, // configurable
                        handlers: {
                            edit: function() { // useful event handlers

                                latexInput.value = mathField.latex();


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
            <p id="Output"></p>

                        <div class="form-group">
                            <form method="get" action="{{ url('student/submitTask', $assignment[0]->id) }}">

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
                                <button class="button-blue my-3 text-white rounded py-2 px-4" type="submit">{{$sub}}</button>
                            @else
                                <button class="button-blue my-3 text-white rounded py-2 px-4" disabled>{{$submited}}</button>
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
    </div>

</x-layout>
