<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
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
        $faker = Factory::create();
        $users = collect(User::where('id', '>', '2')->get()->modelKeys());
        $categories = collect(Category::get()->modelKeys());

        for ($i = 0; $i < 100; $i++) {
            Post::create([
                'title' => $faker->sentence(3),
                'summary' => $faker->text(144),
                'description' => $faker->paragraph,
                'status' => rand(0, 1),
                'comment_able' => rand(0, 1),
                'user_id' => $users->random(),
                'category_id' => $categories->random(),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now', 'Africa/Cairo')
            ]);
        }
    }
}
