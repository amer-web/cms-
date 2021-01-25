<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_page')->only('create');
        $this->middleware('permission:read_page')->only('index');
        $this->middleware('permission:update_page')->only('edit');
    }

    public function index()
    {
        $pages = Post::where('post_type', 'page')->orderBy('created_at', 'desc')->paginate(5);

        return view('backend.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             Post::create([
            'title' => $request['title'],
            'description' => $request->description,
            'category_id' => 1,
            'post_type' => 'page',
            'status' => $request->status,
            'user_id' => Auth::user()->id
            ]);

             return redirect(route('admin.pages.index'))->with('success', 'Page Saved');
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
    public function edit($slug)
    {
        $pageEdit = Post::where('slug', $slug)->where('post_type', 'page')->first();

        return view('backend.pages.edit', compact('pageEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $page)
    {
         $page->update($request->all());
        return redirect(route('admin.pages.index'))->with('success', 'Page Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'the Page has been deleted');
    }
}
