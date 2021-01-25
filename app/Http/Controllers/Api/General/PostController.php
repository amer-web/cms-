<?php

namespace App\Http\Controllers\Api\General;

use App\Helper\ResponseMessages;
use App\Http\Controllers\Controller;
use App\Http\Resources\General\ArchivesResource;
use App\Http\Resources\General\PostResource;
use App\Http\Resources\General\PostsResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentForAdminNotify;
use App\Notifications\NewCommentForOwnerPostNotify;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    use ResponseMessages;
   public function get_posts()
   {
       $posts = Post::whereHas('user', function ($q) {
           $q->where("status", 1);
       })->whereHas('category', function ($q) {
           $q->where("status", 1);
       })->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->get();
      $posts = PostsResource::collection($posts);
       return $this->returnDate('All Posts', $posts,'Success Get All Posts');
   }

   public function show_post($slug)
   {
        $post =  Post::with(['comments' => function($q){
            $q->where('status', 1);
        }])->where('slug', $slug)->first();
        $post = new PostResource($post);
        return $this->returnDate('show post', $post, 'success get post');
   }

   public function showPostByCategory($slug)
   {
       $category_id = Category::whereSlug($slug)->first()->id ;
       $posts = Post::whereHas('category', function ($q) use($category_id){
           $q->where("status", 1)->where('id', $category_id);
       })
           ->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->get();
       $posts = PostsResource::collection($posts);
       return $this->returnDate('All Posts', $posts,'Success Get All Posts By Category');
   }

   public function archives()
   {
       $archives =   Post::select(DB::raw('Month(created_at) as month' ), DB::raw(('Year(created_at) as year')))->where('post_type', 'post')
           ->where('status', 1)->distinct()->orderBy('created_at', 'desc')->limit(5)->get();
       return $this->returnDate('archives', ArchivesResource::collection($archives), 'success');

   }

    public function archive_show($month, $year)
    {
        $posts =  Post::whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('post_type', 'post')->where('status', 1)->orderBy('created_at', 'desc')->get();
        $posts = PostsResource::collection($posts);
        return $this->returnDate('all Post By Archive', $posts,'success');
    }

    public function createComment(Request $request, $idPost)
    {
        if (Auth::guard('api')->check()) {
            $user_id = Auth::guard('api')->id();
            $name    = Auth::guard('api')->user()->username;
            $email   = Auth::guard('api')->user()->email;
            $validator = \Validator::make($request->all(), [
                'comment' => ['required', 'string', 'min:10']
            ]);
        } else {
            $user_id = null;
            $name    = $request->name;
            $email   = $request->email;

            $validator = \Validator::make($request->all(), [
                'name'     => ['required', 'string', 'min:3'],
                'email'   => ['required', 'email'],
                'comment' => ['required', 'string', 'min:10']
            ]);
        }
        if($validator->fails()){
            return $this->msgError($validator->errors(),'401');
        }
        $comment = Comment::create([
            'name' => $name,
            'email' => $email,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
            'post_id' => $idPost,
            'user_id' => $user_id
        ]);
        $adminAndEditor =  User::whereRoleIs(['admin', 'editor'])->pluck('id')->toArray();
        if(auth('api')->guest() || $comment->post->user->id != Auth::guard('api')->id() )
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
        return $this->msgSuccess('Comment Has Been Add');
    }

}
