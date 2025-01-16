<x-front.layout>
    <x-slot name="pageHeader">
        {{ $lastData->title }}
    </x-slot>
    <x-slot name="pageSubheading">
        {{ $lastData->description }}
    </x-slot>
    <x-slot name="pageBackground">
        {{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION')."/".$lastData->thumbnail) }}
    </x-slot>
    <x-slot name="pageHeaderLink">
        {{ route ('blog-detail',['slug'=>$lastData->slug]) }}
    </x-slot>
    <!-- Main Content-->
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    @foreach($Post as $item)
                    <!-- Post preview-->
                    <x-front.blog-list 
                        title="{{ $item->title }}"
                        description="{{ $item->description }}"
                        data="{{ $item->created_at->isoFormat('dddd, D MMMM Y') }}"
                        user='{{ $item->user->name }}' 
                        link="{{ route('blog-detail', ['slug' => $item->slug]) }}"
                    />
                    @endforeach
                    <!-- Pager-->
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            @if(!$Post->onFirstPage())
                            <a class="btn btn-primary text-uppercase" href="{{ $Post->previousPageUrl() }}">&larr; Newer Posts</a>
                            @endif
                        </div>
                        <div>
                            @if($Post->hasMorePages())
                            <a class="btn btn-primary text-uppercase" href="{{ $Post->nextPageUrl() }}">Older Posts &rarr;</a>
                            @endif
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </article>
   
</x-front.layout>



