<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;  // Import model Post
use Illuminate\Http\Request;


class HomepageController extends Controller
{
    public function index()
    {
        $lastData = $this->lastData();

        // Pastikan lastData tidak null sebelum mengakses id-nya
        if ($lastData) {
            $Post = Post::where('id', '!=', $lastData->id)
                ->where('status', 'publish') // Filter berdasarkan status
                ->orderBy('id', 'desc')
                ->paginate(2);
        } else {
            // Jika tidak ada lastData, ambil semua post yang dipublish
            $Post = Post::where('status', 'publish')
                ->orderBy('id', 'desc')
                ->paginate(2);
        }

        return view('components.front.home-page', compact('Post','lastData'));
    }

    private function lastData()
    {
        return Post::where('status', 'publish')->orderBy('id', 'desc')->first();
    }
}