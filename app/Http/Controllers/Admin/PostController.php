<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Jobs\PostFormFields;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('admin.post.index')
            ->withPosts(Posts::all());
    }

    public function create()
    {
        var_dump(new PostFormFields());
        $data = $this->dispatch(new PostFormFields());//推送任务到队列
//var_dump($data);
//        die;
        return view('admin.post.create',$data);
    }

    public function store(PostCreateRequest $request)
    {
        $post = Posts::create($request->postFillData());
        $post->syncTags($request->get('tags',[]));

        return redirect()
                        ->route('admin.post.index')
                        ->withSuccess('New Post Successfully Created.');
    }

    public function edit($id)
    {
        $data = $this->dispatch(new PostFormFields($id));

        return view('admin.pot.edit',$data);
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
    }

    public function destroy($id)
    {
        $post = Posts::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        return redirect()
                    ->route('admin.post.index')
                    ->withSuccess('Post deleted.');
    }
    
}
