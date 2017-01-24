<?php

namespace App\Jobs;

use App\Models\Posts;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostFormFields implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    protected $fieldList = [
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
    ];


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fields = $this->fieldList;

        if($this->id){
            $fields = $this->fieldsFromModel($this->id,$fields);
        }else{
            $when = Carbon::now()->addHour();
            $fields['publish_date'] = $when->format('M-j-Y');
            $fields['publish_time'] = $when->format('g:i A');
        }

        foreach($fields as $filedName => $filedValue){
            $fields[$filedName] = old($filedName,$filedValue);
        }

        $data =  array_merge(
          $fields,
            [
                'allTags'=>''
            ]
        );

        return $data;
    }

    protected function fieldsFromModel($id,array $fields)
    {
        $post = Posts::findOrFail($id);
        $fieldName = array_keys(array_except($this->fieldList,['tags']));

        $fields =['id'=>$id];
        foreach($fieldName as $field){
            $fields[$field] = $post->{$field};
        }

        $fields['tags'] = $post->tags()->pluck('tag')->all();

        return $fields;
    }
}
