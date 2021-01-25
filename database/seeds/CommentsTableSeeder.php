<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $users = collect(User::where('id', '>', '2')->get()->modelKeys());
        $posts = collect(Post::where('post_type','post')->where('status', 1)->where('comment_able',1)->get());
        for ($i = 0; $i < 100; $i++) {
            Comment::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'url' => $faker->url,
                'ip_address' => $faker->ipv4,
                'comment' => $faker->paragraph,
                'status' => rand(0, 1),
                'post_id' => $posts->random()->id,
                'user_id' => $users->random(),
                'created_at' => $faker->dateTimeBetween('-2 year', 'now', 'Africa/Cairo')
            ]);
        }
    }
}
