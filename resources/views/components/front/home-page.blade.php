
<x-front.layout>
    <!-- Main Content-->
    <div class="container px-4 px-lg-5">
     <div class="row gx-4 gx-lg-5 justify-content-center">
         <div class="col-md-10 col-lg-8 col-xl-7">
            @foreach($Post as $item)
            <!-- Post preview-->
            <x-front.blog-list 
                title="{{ $item->title }}"
                description="{{ $item->description }}"
                data="{{ $item->created_at->isoFormat('LL') }}"
                user="{{ $item->user->name }}"
                
            />
        @endforeach
        <!-- Pager-->
             <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="#!">Older Posts →</a></div>
         </div>
     </div>
 </div>
</x-front.layout>
 
      
        
  
 