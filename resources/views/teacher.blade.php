<?php
if (!session()->has('language')) {
    session(['language' => 'english']);
}
$en = false;
if (session('language') == 'english') {
    $en = true;
}
if ($en){
    $noFiles = "No files found";
    $exercises = "Exercises";
    $from = "From";
    $to = "To";
    $point = "Points";
    $edit = "Edit";
    $seeTable = "See table";

} else {
    $noFiles = "Žiadne súbory";
    $exercises = "Cvičenia";
    $from = "Od";
    $to = "Do";
    $point = "Body";
    $edit = "Edituj";
    $seeTable = "Pozri tabuľku";
}
?>
<x-layout>
    <div class="container">
        @if(count($files) == 0)
            <h2>{{$noFiles}}</h2>
        @else
            <div class="row">
                @foreach($files as $file)
                    <div class="col-md-3 mb-4">
                        <x-card>
                            <header class="text-center">
                                <h2 class="text-2xl font-bold uppercase mb-1">
                                    {{$file->name}}
                                </h2>
                                <p class="mb-4">{{$exercises}}</p>
                            </header>

                            <div class="mb-6 d-flex justify-content-center">
                                <img src="{{ asset('pics/function.webp') }}" alt="Function Picture"
                                     style="max-width: 20%; height: auto;">
                            </div>

                            <form method="POST" action="{{route('file.edit', ['name' => $file->name]) }}">
                                @csrf
                                <div class="mb-6">
                                    <label for="from" class="inline-block text-lg mb-2">{{$from}}</label>
                                    <input
                                        type="date"
                                        class="border border-gray-200 rounded p-2 w-full"
                                        name="from"
                                        value="{{$file->from}}"
                                    />
                                    <!-- Error Example -->
                                    @error('from')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label
                                        for="to"
                                        class="inline-block text-lg mb-2">
                                        {{$to}}
                                    </label>
                                    <input
                                        type="date"
                                        class="border border-gray-200 rounded p-2 w-full"
                                        name="to"
                                        value="{{$file->to}}"
                                    />
                                    @error('to')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label
                                        for="points"
                                        class="inline-block text-lg mb-2">
                                        {{ $point }}
                                    </label>
                                    <input
                                        type="number"
                                        class="border border-gray-200 rounded p-2 w-full"
                                        name="points"
                                        value="{{$file->points}}"
                                    />
                                    @error('points')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <button
                                        type="submit"
                                        class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                                        {{ $edit }}
                                    </button>
                                </div>
                            </form>
                        </x-card>
                    </div>
                @endforeach
            </div>
        @endif
            <div class="mb-6">
                <a href="{{route('teacher.table')}}" class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                    {{ $seeTable }}
                </a>
            </div>
    </div>
</x-layout>
