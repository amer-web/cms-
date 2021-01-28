<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->is('admin*')){
            view()->composer('*', function ($view){
                if(!Cache::has('admins')){
                    $rolesAdmin = Role::whereNotIn('name',['user'])->pluck('name')->toArray();
                    $usersAdmins = User::whereRoleIs($rolesAdmin)->get();
                    Cache::remember('userAdmins', 50, function() use ($usersAdmins) {
                       return $usersAdmins;
                    });
                }
                $usersAdmins = Cache::get('userAdmins');
                $view->with([
                   'userAdmins' => $usersAdmins
                ]);

            });
        }

        if (!request()->is('admin/*')) {
            view()->composer('*', function ($view) {
                if (!Cache::has('categories')) {
                    $categories = Category::with('posts')->whereHas('posts', function ($q) {
                        $q->where("status", 1);
                    })->where('status', 1)->limit(5)->get();

                    Cache::remember('categories', 20, function () use ($categories) {
                        return $categories;
                    });
                }

                if (!Cache::has('latest_posts')) {

                    $latest_posts = Post::with(['user', 'category', 'media'])->whereHas('user', function ($q) {
                        $q->where("status", 1);
                    })->whereHas('category', function ($q) {
                        $q->where("status", 1);
                    })
                        ->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->limit(5)->get();

                    Cache::remember('latest_posts', 20, function () use ($latest_posts) {
                        return $latest_posts;
                    });
                }
                $archives =   Post::select(DB::raw('Month(created_at) as month' ), DB::raw(('Year(created_at) as year')))->where('post_type', 'post')
                            ->where('status', 1)->distinct()->orderBy('created_at', 'desc')->limit(5)->get();
                Cache::remember('archives', 40, function () use ($archives) {
                    return $archives;
                });
                if(!Cache::has('pages'))
                {
                  $pages =  Post::where('post_type', 'page')->where('status', 1)->get();

                    Cache::remember('pages', 3600, function () use ($pages) {
                        return $pages;
                    });

                }
                if(!Cache::has('latest_comments')){
                 $latest_comments = Comment::where('status', 1)->orderBy('created_at', 'desc')->limit(5)->get();
                 Cache::remember('latest_comments', 3600, function () use ($latest_comments){
                    return  $latest_comments;
                 });
                }

                $archives = Cache::get('archives');
                $categories = Cache::get('categories');
                $latest_posts = Cache::get('latest_posts');
                $pages = Cache::get('pages');
                $latest_comments = Cache::get('latest_comments');

                $view->with([
                    'categories'=> $categories,
                    'latest_posts' => $latest_posts,
                    'archives'  => $archives,
                    'pages' => $pages,
                    'latest_comments' => $latest_comments,
                    ]);
            });
        }
    }
}
