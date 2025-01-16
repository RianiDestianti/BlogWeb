<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post; // Import the Post model
use Illuminate\Http\Request;

class BlogDetailController extends Controller
{
    function detail($slug)
    {
        $data = Post::where('status', 'publish')->where('slug', $slug)->firstOrFail();

        // Get the previous and next posts
        $prevPost = Post::where('status', 'publish')
            ->where('id', '<', $data->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextPost = Post::where('status', 'publish')
            ->where('id', '>', $data->id)
            ->orderBy('id', 'asc')
            ->first();

        // Prepare pagination data
        $pagination = [
            'prev' => $prevPost,
            'next' => $nextPost,
        ];

        return view('components.front.blog-detail', compact('data', 'pagination'));
    }
}