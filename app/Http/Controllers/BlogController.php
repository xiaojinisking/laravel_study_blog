<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //列表
    public function index()
    {
        $posts = Posts::where('published_at','<=',Carbon::now())
                ->orderBy('published_at','desc')
                ->paginate(config('blog.posts_per_page'));

        return view('blog.index',compact('posts'));


        
    }
    
    //详情
    public function showPost($slug)
    {
        $post = Posts::whereslug($slug)->firstOrFail();
        return view('blog.post')->withPost($post);
    }
}
