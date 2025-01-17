<?php
namespace App\Http\Controllers\Member;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->search;

    return view('member.blogs.index', [
        'Post' => Post::where('user_id', $user->id)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(3)
            ->withQueryString()
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('member.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:10240'
        ], [
            'title.required' => 'Judul Wajib Diisi',
            'content.required' => 'Konten Wajib Diisi',
            'thumbnail.image' => 'Hanya Gambar Yang Diperbolehkan',
            'thumbnail.mimes' => 'Ekstensi Yang Diperbolehkan Hanya JPEG, JPG, Dan PNG',
            'thumbnail.max' => 'Ukuran Maksimum Untuk Thumbnail Adalah 10MB',
        ]);

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store the file using Storage facade
            Storage::disk('public')->put(
                env('CUSTOM_THUMBNAIL_LOCATION') . '/' . $image_name, 
                file_get_contents($image)
            );
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'thumbnail' => isset($image_name) ? $image_name : null,
            'slug' => $this->generateSlug($request->title),
            'user_id' => Auth::user()->id
        ];
        Post::create($data);
        return redirect()->route('member.blogs.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('edit',$post);
        $data = $post;
        return view('member.blogs.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:10240'
        ], [
            'title.required' => 'Judul Wajib Diisi',
            'content.required' => 'Konten Wajib Diisi',
            'thumbnail.image' => 'Hanya Gambar Yang Diperbolehkan',
            'thumbnail.mimes' => 'Ekstensi Yang Diperbolehkan Hanya JPEG, JPG, Dan PNG',
            'thumbnail.max' => 'Ukuran Maksimum Untuk Thumbnail Adalah 10MB',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if (isset($post->thumbnail)) {
                Storage::disk('public')->delete(env('CUSTOM_THUMBNAIL_LOCATION') . '/' . $post->thumbnail);
            }
            
            // Store new thumbnail
            $image = $request->file('thumbnail');
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            
            Storage::disk('public')->put(
                env('CUSTOM_THUMBNAIL_LOCATION') . '/' . $image_name, 
                file_get_contents($image)
            );
        }
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'status' => $request->status,
            'thumbnail' => isset($image_name) ? $image_name : $post->thumbnail,
            'slug' => $this->generateSlug($request->title, $post->id)
        ];
        Post::where('id', $post->id)->update($data);
        return redirect()->route('member.blogs.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete',$post);
        
        if (isset($post->thumbnail) && file_exists(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION')) . "/" . $post->thumbnail)) {
            unlink(public_path(getenv('CUSTOM_THUMBNAIL_LOCATION')) . "/" . $post->thumbnail);
        }

        $post->delete();

        return redirect()->route('member.blogs.index')->with('success', 'Data Berhasil Dihapus');
    }

    private function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = Post::where('slug', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->count();

        if ($count > 0) {
            $slug = $slug . "-" . ($count + 1);
        }
        return $slug;
    }
}


