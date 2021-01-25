<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = ['post', 'page', 'comment', 'category', 'user', 'message', 'role'];
        $contents = ['read', 'create', 'update', 'delete'];

        foreach ($models as $model) {
            foreach($contents as $content)
            {
                   $per =  Permission::create([
                    'name' => $content . '_' . $model,
                    'display_name' => $content .' '. $model,
                    'description' =>  $content . ' A ' . $model . ' Only'
                ]);
                 \App\Models\Role::find(1)->attachPermission($per);
            }
        }


    }
}
