<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;

class IndexController extends Controller
{
    public function index()
    {
       $users = User::whereRoleIs('user')->count();
       $activePosts = Post::where('status', 1)->where('post_type', 'post')->count();
       $comments = Comment::count();
       $contact = Contact::where('status', 0)->count();
       $last_posts = Post::where('post_type', 'post')->orderBy('created_at', 'desc')->limit(5)->get();
       $last_comments = Comment::orderBy('created_at', 'desc')->limit(5)->get();
        return view('backend.index', compact(['users', 'activePosts', 'comments', 'contact', 'last_posts', 'last_comments']));
    }
}
