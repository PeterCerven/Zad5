<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $login = "Log in";
    $logAccout = "Log into your account";
    $email = "Email:";
    $password = "Password:";
    $signin = "Sign in";
} else {
    $login = "Prihlásenie";
    $logAccout = "Prihlás sa do konta";
    $email = "Email:";
    $password = "Heslo:";
    $signin = "Prihlásiť";
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
    <x-card class="p-10 max-w-lg mx-auto mt-24" style="box-shadow:1px 1px 10px rgba(0,0,0,0.5);">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                {{ $login }}
            </h2>
            <p class="mb-4">{{$logAccout}}</p>
        </header>

        <form method="POST" action="{{route('users.authenticate')}}">
            @csrf
            <div class="mb-6 font-bold">
                <label for="email" class="inline-block text-lg mb-2">{{$email}}</label>
                <input
                    type="email"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="email"
                    value="{{ old('email')}}"
                />
                <!-- Error Example -->
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 font-bold">
                <label
                    for="password"
                    class="inline-block text-lg mb-2">
                    {{$password}}
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password"
                    value="{{old('password')}}"
                />
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6 d-flex justify-content-center">
                <button
                    type="submit"
                    class="button-blue text-white rounded py-2 px-4">
                    {{$signin}}
                </button>
            </div>
        </form>
    </x-card>
</x-layout>
