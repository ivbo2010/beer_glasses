<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::truncate();
        DB::table('tags')->truncate();
        $tags =Tag::create([
            'name' => 'leger'
        ]);
    }
}
