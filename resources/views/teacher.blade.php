<x-layout>
    @if(count($files) == 0)
        <h2>No listings found</h2>
    @else
        @foreach($files as $file)
                <?php echo $file->name; ?>
        @endforeach
    @endif
</x-layout>
