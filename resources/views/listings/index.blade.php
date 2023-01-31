<x-layout>
    @include('partials._hero')
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @if(count($listing)==0)
            <p>No job listing at the moment. </p>
        @else
            @foreach($listing as $list)
                <x-listing-card :list="$list"/>
                
            @endforeach
        @endif
    </div>
    <div class="mt-6 px-4">
        {{ $listing->links() }}
    </div>
</x-layout>
