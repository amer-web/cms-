<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewCommentForAdminNotify;
use App\Notifications\NewCommentForOwnerPostNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'media'])->whereHas('user', function ($q) {
            $q->where("status", 1);
        })->whereHas('category', function ($q) {
            $q->where("status", 1);
        })
            ->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->paginate(6);

        return view('frontend.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'media', 'comments' => function ($q) {
            $q->where('status', 1);
        }])->where('slug', $slug)->first();

        return view('frontend.postdetails', compact('post'));
    }

    public function store(Request $request, $post)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $name    = Auth::user()->username;
            $email   = Auth::user()->email;
            $this->validate($request, ['comment' => ['required', 'string', 'min:10']]);
        } else {
            $user_id = null;
            $name    = $request->name;
            $email   = $request->email;
            $this->validate($request, [
                'name'     => ['required', 'string', 'min:3'],
                'email'   => ['required', 'email'],
                'comment' => ['required', 'string', 'min:10']
            ]);
        }

       $comment = Comment::create([
            'name' => $name,
            'email' => $email,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
            'post_id' => $post,
            'user_id' => $user_id
        ]);
            $adminAndEditor =  User::whereRoleIs(['admin', 'editor'])->pluck('id')->toArray();
            if(auth()->guest() || $comment->post->user->id != Auth::id() )
            {
                if(!in_array($comment->post->user->id, $adminAndEditor))
                {
                    $comment->post->user->notify((new NewCommentForOwnerPostNotify($comment)));
                }
            }
            $admins = User::whereRoleIs(['admin', 'editor']);
            if($comment->user_id != null){
             $admins =  $admins->whereNotIn('id', [$comment->user_id]);
            }
          $admins =  $admins->get();
            foreach($admins as $admin)
            {
                $admin->notify(new NewCommentForAdminNotify($comment));
            }
        return redirect()->back()->with('success', 'Comment Has Been Add');
    }

    public function page_show($slug)
    {
        $page = Post::with(['user', 'category', 'media', 'comments' => function ($q) {
            $q->where('status', 1);
        }])->where('slug', $slug)->where('status', 1)->first();

        return view('frontend.page', compact('page'));
    }

   public function category_show($slug)
   {
        $category_id = Category::whereSlug($slug)->first()->id ;

       $posts = Post::with(['user', 'category', 'media'])->whereHas('category', function ($q) use($category_id){
            $q->where("status", 1)->where('id', $category_id);
        })
            ->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->paginate(6);

        return view('frontend.index', compact('posts'));
   }

   public function archive_show($month, $year)
   {
       $posts =  Post::whereMonth('created_at', $month)->whereYear('created_at', $year)
        ->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->paginate();
        return view('frontend.index', compact('posts'));
   }
}
