<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'administrator',
            'description' => 'system administrator',
        ]);

        $adminEditor = Role::create([
            'name' => 'editor',
            'display_name' => 'subervisor',
            'description' => 'system subervisor',
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'user',
            'description' => 'system user',
        ]);


        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'mobile' => '01112795101',
            'email_verified_at' => Carbon::now('Africa/Cairo'),
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);
        $admin->attachRole('admin');
        $editor = User::create([
            'name' => 'editor',
            'username' => 'editor',
            'email' => 'editor@editor.com',
            'mobile' => '01060253939',
            'email_verified_at' => Carbon::now('Africa/Cairo'),
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);
        $editor->attachRole('editor');
        $user1 = User::create([
            'name' => 'user1',
            'username' => 'user1',
            'email' => 'user@admin.com',
            'mobile' => '0111455071',
            'email_verified_at' => Carbon::now('Africa/Cairo'),
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);
        $user1->attachRole('user');
        $user2 = User::create([
            'name' => 'user2',
            'username' => 'user2',
            'email' => 'user2@admin.com',
            'mobile' => '0111455072',
            'email_verified_at' => Carbon::now('Africa/Cairo'),
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);
        $user2->attachRole('user');
        $user3 = User::create([
            'name' => 'user3',
            'username' => 'user3',
            'email' => 'user3@admin.com',
            'mobile' => '0111455073',
            'email_verified_at' => Carbon::now('Africa/Cairo'),
            'password' => bcrypt('123456'),
            'status' => 1,
        ]);
        $user3->attachRole('user');
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->email,
                'mobile' => $faker->phoneNumber,
                'email_verified_at' => Carbon::now('Africa/Cairo'),
                'password' => bcrypt('123456'),
                'status' => rand(0, 1)
            ]);
            $user->attachRole('user');
        }
    }
}
