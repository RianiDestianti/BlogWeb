<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('member.blogs.index',[
        'Post'=> Post::latest()->paginate(3)
    ]);
        // $data = Post::where('user_id',$user->id)->orderBy('id','desc')->get();
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $data = $post;
        return view('member.blogs.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'thumbnail'=>'image|mimes:jpeg,jpg,png|max:10240'
        ],[
            'title.required'=>'Judul Wajib Diisi',
            'content.required'=>'Konten Wajib Diisi',
            'thumbnail.image'=>'Hanya Gambar Yang Diperbolehkan',
            'thumbnail.mimes'=>'Ekstensi Yang Diperbolehkan Hanya JPEG, JPG, Dan PNG',
            'thumbnail.max'=>'Ukuran Maksimum Untuk Thumbnail Adalah 10MB',
        ]);

        if($request->hasFile('thumbnail')){
            $image = $request->file('thumbnail');
            $image_name = time()."_".$image->getClientOriginalName();
            $destination_path = public_path('thumbnails');
            $image->move($destination_path, $image_name);
        };

        $data=[
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'status'=>$request->status,
            'thumbnail'=>isset($image_name)?$image_name:$post->thumbnail
        ];
        Post::where('id',$post->id)->update($data);
        return redirect()->route('member.blogs.index')->with('success','Data Berhasil Di-Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
