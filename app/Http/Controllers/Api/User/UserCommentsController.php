<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\ResponseMessages;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserDash\CommentsEditResource;
use App\Http\Resources\UserDash\CommentsResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserCommentsController extends Controller
{
    use ResponseMessages;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = \auth('api')->user()->allComments()->orderBy('created_at', 'desc')->get();
                /* OR */
//        $posts_id = Post::where('user_id', Auth::guard('api')->user()->id)->pluck('id')->toArray();
//        $comments = Comment::whereIn('post_id', $posts_id)->orderBy('created_at', 'desc')->get();
        $comments = CommentsResource::collection($comments);
        return $this->returnDate('comments', $comments, 'success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::where('id', $id)->whereHas('post', function($q){
            $q->where('user_id', Auth::guard('api')->id());
        })->first();
        if($comment == null)
        {
            return $this->msgError('Not Found', 404);
        }
        $comment = new CommentsEditResource($comment);
        return $this->returnDate('comment', $comment,'success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
                $this->validate($request, [
            'comment' => 'required|string|min:10',
            'status' => 'required'
        ]);
       $comment = Comment::find($id);
       $comment->update([
          'comment' => $request->comment,
          'status' => $request->status
       ]);

       return $this->msgSuccess('success update comment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $my_comment)
    {
        $my_comment->delete();
        return $this->msgSuccess('Success Delete Comment');
    }
}
