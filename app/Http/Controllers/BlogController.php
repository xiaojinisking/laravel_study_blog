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
        Posts::where('published_at','<=',Carbon::now())
            ->

        
    }
    
    //详情
    public function showPost()
    {
        
    }
}
