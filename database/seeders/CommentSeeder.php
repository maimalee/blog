<?php

namespace Database\Seeders;

use App\Models\Comments;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comments::factory(mt_rand(10,20))->create();
    }
}
