<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogDetailController extends Controller
{
   function detail($slug){
    echo $slug;

   }
}
