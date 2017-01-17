<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //方法1：使用查询构造器生成数据
//        DB::table('posts')->insert(
//          [
//              'slug'=>mt_rand(3, 10),
//              'title'=>mt_rand(3, 10),
//              'content'=>mt_rand(3, 6),
//              'published_at'=>date('Y-m-d')
//          ]
//        );

        //方法2:使用数据工厂
        \App\Models\Posts::truncate();
//        factory(\App\Models\Posts::class,20)->create([
//            'title'=>'abc'
//        ]);

        factory(\App\Models\Posts::class,'adminuser',20)->create();

    }
}
