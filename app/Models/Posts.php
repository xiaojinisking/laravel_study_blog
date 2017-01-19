<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Michelf\Markdown;

class Posts extends Model
{
    protected $dates = ['published_at'];   //应用被调整成日期的属性


    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','post_tag_pivot');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (! $this->exists) {
            $this->setUniqueSlug($value,'');
        }

    }

    protected function setUniqueSlug($title,$extra)
    {
        $slug = str_slug($title.'-'.$extra);
        if(static::whereSlug($slug)->exists()){
            $this->setUniqueSlug($title,$extra+1);
            return;
        }
        $this->attributes['slug'] = $slug;
    }

    protected function setContentRawAttribute($value)
    {
        $markdown = new Markdown();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdown->toHtml($value);
    }

    /**
     * Sync tag relation adding new tags as needed
     *
     * @param array $tags
     */
    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if (count($tags)) {
            $this->tags()->sync(
                Tag::whereIn('tag', $tags)->lists('id')->all()
            );
            return;
        }

        $this->tags()->detach();
    }

}
