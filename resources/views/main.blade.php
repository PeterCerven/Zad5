
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


<x-layout>
    <div class="container mt-5">
        <div class="d-flex align-items-center justify-content-center">
            <div class="mb-6">
                <a href="/teacher" class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                    {{ $toTeacherPage }}
                </a>
            </div>
            <div class="mb-6">
                <a href="/student" class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                    {{ $toStudentPage }}
                </a>
            </div>
        </div>
    </div>

</x-layout>

