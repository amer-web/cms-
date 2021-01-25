<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_comment')->only('create');
        $this->middleware('permission:read_comment')->only('index');
        $this->middleware('permission:update_comment')->only('edit');
    }

    public function index()
    {
        $comments = Comment::orderBy('created_at', 'desc');
        if(request()->keywords != null)
        {
            $comments = $comments->search(request()->keywords, null, true);
        }
        if(request()->status != null)
        {
            $comments = $comments->where('status', request()->status);
        }

        $paginate = (isset(request()->paginate) && request()->paginate != null) ? request()->paginate : '10';
        $comments = $comments->paginate($paginate);
        return view('backend.comments.index',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

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
    public function edit(Comment $comment)
    {
        $commentEdit = $comment;
        return view('backend.comments.edit', compact('commentEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Comment $comment)
    {
       $comment->update($request->all());
      return back()->with('success', 'Comment Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'the Comment has been deleted');
    }
}
