<?php

declare(strict_types=1);

namespace Modules\Shop\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Database\Seeders\XotDatabaseSeeder;

class ShopDatabaseSeeder extends XotDatabaseSeeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        DB::table('tags')->insert([
            'parent_id' => '0',
            'tag_cat_id' => '0',
        ]);
        DB::table('tags')->insert([
            'parent_id' => '0',
            'tag_cat_id' => '0',
        ]);
        DB::table('tags')->insert([
            'parent_id' => '0',
            'tag_cat_id' => '0',
        ]);
        /*------------------------------*/
        DB::table('tags')->insert([
            'parent_id' => '1',
            'tag_cat_id' => '0',
        ]);
        DB::table('tags')->insert([
            'parent_id' => '1',
            'tag_cat_id' => '0',
        ]);
        /*-------------------------*/
        DB::table('posts')->insert([
            'post_type' => 'tag',
            'post_id' => '1',
            'lang' => 'it',
            'title' => 'pizze',
            'image_src' => 'http://fastorder.local/storage/photos/1/Categorie madri/pizza.png',
        ]);
        DB::table('posts')->insert([
            'post_type' => 'tag',
            'post_id' => '2',
            'lang' => 'it',
            'title' => 'bibite',
            'image_src' => 'http://fastorder.local/storage/photos/1/Categorie madri/pizza.png',
        ]);
        DB::table('posts')->insert([
            'post_type' => 'tag',
            'post_id' => '3',
            'lang' => 'it',
            'title' => 'snack',
            'image_src' => 'http://fastorder.local/storage/photos/1/Categorie madri/pizza.png',
        ]);
        DB::table('posts')->insert([
            'post_type' => 'tag',
            'post_id' => '4',
            'lang' => 'it',
            'title' => 'Le Classiche',
        ]);
        DB::table('posts')->insert([
            'post_type' => 'tag',
            'post_id' => '5',
            'lang' => 'it',
            'title' => '4 Stagioni',
        ]);
    }
}
