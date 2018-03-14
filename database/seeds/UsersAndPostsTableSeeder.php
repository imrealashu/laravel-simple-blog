<?php

use Illuminate\Database\Eloquent\Faker;
use Illuminate\Database\Seeder;

class UsersAndPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 5)->create()->each(function ($u) {
            // Generating 5 Posts for each User.
            for($i = 0; $i < 5; $i++){
                $u->posts()->save(factory(App\Post::class)->make());
            }
        });
        factory(App\User::class)->create([
            'email' => 'imrealashu@gmail.com'
        ]);
    }
}
