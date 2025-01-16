<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post; // Import the Post model
use Illuminate\Http\Request;

class BlogDetailController extends Controller
{
    function detail($slug) // Change parameter to $slug
    {
        $data = Post::where('status', 'publish')->where('slug', $slug)->firstOrFail();
        
        return view('components.front.blog-detail', compact('data')); // Remove the extra compact
    }
}