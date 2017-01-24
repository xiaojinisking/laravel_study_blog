<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Jobs\PostFormFields;
use App\Models\Posts;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    protected $fields = [
        'title' => '',
        'subtitle' => '',
        'page_image' => '',
        'content_raw' => '',
        'meta_description' => '',
        'is_draft' => "0",
        'publish_date' => '',
        'publish_time' => '',
        'layout' => 'blog.layouts.post',
        'tags' => [],
        'allTags'=>[]
    ];
    //
    public function index()
    {
        return view('admin.post.index')
            ->withPosts(Posts::all());
    }

    public function create()
    {
        $data = [];
        $when = Carbon::now()->addHour();
        $extra_fields['publish_date'] = $when->format('M-j-Y');
        $extra_fields['publish_time'] = $when->format('g:i A');
        $extra_fields['allTags'] = Tag::pluck('tag')->all();
        $fields = array_merge($this->fields,$extra_fields);
        foreach($fields as $field=>$default){
            $data[$field] = old($field,$default);
        }

        return view('admin.post.create',$data);
    }

    public function store(PostCreateRequest $request)
    {
        $post = Posts::create($request->postFillData());
        $post->syncTags($request->get('tags',[]));

        return redirect('/admin/post')
                        ->withSuccess('New Post Successfully Created.');
    }

    public function edit($id)
    {
        $post = Posts::findOrFail($id);
        $data = ['id'=>$id];
        foreach(array_keys(array_except($this->fields,['tags'])) as $field){
            $data[$field] = old($field,$post->$field);
        }
        $data['allTags'] = Tag::pluck('tag')->all();
        $data['tags'] = $post->tags()->pluck('tag')->all();
        return view('admin.post.edit',$data);
    }

    public function update(PostUpdateRequest $request,$id)
    {
        $post = Posts::findOrFail($id);
        $post->fill($request->postFillData());
        $post->save();
        $post->syncTags($request->get('tags',[]));

        if($request->action ==='continue'){
            return redirect()
                            ->back()
                            ->withSuccess('Pot saved.');
        }
        return redirect('/admin/post')
            ->withSuccess('Post saved.');
    }

    public function destroy($id)
    {
        $post = Posts::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        return redirect('/admin/post')
                    ->withSuccess('Post deleted.');
    }
    
}
