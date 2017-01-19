<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //可赋值字段
    protected $fillable = [
        'tag','title','subtitle','page_image','meta_decription','reverse_direction'
    ];

    //文章与标签的关系 多对多
    public function posts()
    {
        return $this->belongsToMany('App\Models\Posts','post_tag_pivot');
    }

    public static function addNeededTags(array $tags)
    {
        if(count($tags) == 0)
        {
            return;
        }
        $found = static::whereIn('tag',$tags)->lists('tag')->all();

        foreach(array_diff($tags,$found) as $tag)
        {
            static::create([
                'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for '.$tag,
                'page_image' => '',
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
    }

}
