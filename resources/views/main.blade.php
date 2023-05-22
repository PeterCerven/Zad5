<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $toTeacherPage = "Go to teacher's page";
    $toStudentPage = "Go to student's page";
} else {
    $toTeacherPage = "Choď na stránku učiteľa";
    $toStudentPage = "Choď na stránku žiaka";
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
    <div class="container mt-20">
        <div class="d-flex align-items-center justify-content-center">
            <div class="mb-6 me-3">
                <a href="/teacher" class="button-blue text-white rounded py-2 px-4">
                    {{ $toTeacherPage }}
                </a>
            </div>
            <div class="mb-6">
                <a href="/student" class="button-blue text-white rounded py-2 px-4">
                    {{ $toStudentPage }}
                </a>
            </div>
        </div>
    </div>
</x-layout>

