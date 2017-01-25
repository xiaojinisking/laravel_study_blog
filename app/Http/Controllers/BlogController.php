<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //列表
    public function index(Request $request)
    {
        $tag = $request->get('tag');


        if($tag){
            $tag = Tag::where('tag',$tag)->firstOrFail();
            $reverse_direction = (bool)$tag->reverse_direction;

            $posts = Posts::where('published-at','<=',Carbon::now())
                ->wherehas('tag',function($q) use ($tag){
                    $q->where('tag','=',$tag->tag);
                })
                ->where('is_draft',0)
                ->orderBy('published_at',$reverse_direction?'asc':'desc')
                ->simplepaginate(config('blog.posts_per_page'));
            $posts->addQuery('tag',$tag->tag);

            $page_image = $tag->page_image ? :config('blog.page_image');
            $data = [
                'title' => $tag->title,
                'subtitle' => $tag->subtitle,
                'posts' => $posts,
                'page_image' => $page_image,
                'tag' => $tag,
                'reverse_direction' => $reverse_direction,
                'meta_description' => $tag->meta_description ? : config('blog.description')
            ];
        }else{
            $posts = Posts::with('tags')
                        ->where('published_at','<=',Carbon::now())
                        ->where('is_draft',0)
                        ->orderBy('published_at','desc')
                        ->simplePaginate(config('blog.posts_per_page'));
            $data =  [
                'title' => config('blog.title'),
                'subtitle' => config('blog.subtitle'),
                'posts' => $posts,
                'page_image' => config('blog.page_image'),
                'meta_description' => config('blog.description'),
                'reverse_direction' => false,
                'tag' => null,
            ];
        }



        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';

        return view($layout,$data);


        die;

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
