<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:create_post')->only('create');
        $this->middleware('permission:read_post')->only('index');
        $this->middleware('permission:update_post')->only('edit');
    }
    public function index()
    {
        $posts = Post::where('post_type', 'post')->orderBy('created_at', 'desc');
        if(request()->keywords != null)
        {
              $posts = $posts->search(request()->keywords, null, true);
        }
        if(request()->status != null)
        {
            $posts = $posts->where('status', request()->status);
        }
        if(request()->category_id != null)
        {
            $posts = $posts->where('category_id', request()->category_id);
        }
        $paginate = (isset(request()->paginate) && request()->paginate != null) ? request()->paginate : '10';
        $posts = $posts->paginate($paginate);
        $categories = Category::select('id', 'name')->get();
        return view('backend.posts.index',compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
       return view('backend.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $create_post = Post::create([
            'title' => $request['title'],
            'summary' => $request->summary,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'comment_able' => $request->comment_able,
            'status' => $request->status,
            'user_id' => Auth::user()->id
            ]);
            if (request('status') == 1) {
                    Cache::forget('latest_posts');
                }
        if ($request->post_media != null) {
            $i = 1;
            foreach ($request->post_media as $image_post) {
                $fileName = $create_post->slug . '-' . time() . '-' . $i . '.' .  $image_post->getClientOriginalExtension();
                $file_type = $image_post->getMimeType();
                $file_size = $image_post->getSize();
                $path = public_path('assest\posts\\' . $create_post->slug);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $path_image = $path . '\\' . $fileName;
                $file_image = 'assest/posts/' . $create_post->slug . '/' . $fileName;
                Image::make($image_post->getRealPath())->resize(1170, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(1170, 555, 0, 0)->save($path_image, 100);
                PostMedia::create([
                    'post_id' => $create_post->id,
                    'file_name' => $file_image,
                    'file_type' => $file_type,
                    'file_size' => $file_size
                ]);
                $i++;
            }
        }
        // if($request->status == 1)
        // {
        //     return redirect(route('dashboard.index'))->with('success', 'Published successfully Subject Name: ' . $create_post->title);
        // }
        //     return redirect(route('dashboard.index'))->with('success', 'Post Saved');
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
        $postEdit = Post::where('slug', $slug)->first();
        $categories = Category::where('status', 1)->get();
        return view('backend.posts.edit', compact('postEdit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request,Post $post)
    {
        if (request('status') == 1) {
            Cache::forget('latest_posts');
        }
         $post->update(
             [
                'title' => $request->title,
                'summary' => $request->summary,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'comment_able' => $request->comment_able,
                'status' => $request->status,
             ]
         );

        if ($request->post_media != null) {
            $i = 1;
            foreach ($request->post_media as $image_post) {
                $fileName = $post->slug . '-' . time() . '-' . $i . '.' .  $image_post->getClientOriginalExtension();
                $file_type = $image_post->getMimeType();
                $file_size = $image_post->getSize();
                $path = public_path('assest\posts\\' . $post->slug);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $path_image = $path . '\\' . $fileName;
                $file_image = 'assest/posts/' . $post->slug . '/' . $fileName;
                Image::make($image_post->getRealPath())->resize(1170, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(1170, 555, 0, 0)->save($path_image, 100);
                PostMedia::create([
                    'post_id' => $post->id,
                    'file_name' => $file_image,
                    'file_type' => $file_type,
                    'file_size' => $file_size,
                ]);
                $i++;
            }
        }

        return redirect(route('admin.posts.index'))->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->media->count() > 0) {
            foreach ($post->media as $images_deletes) {
                $dirfile = str_replace('/', '\\', public_path($images_deletes->file_name));
                unlink($dirfile);
            }

            $dirfile =  dirname($dirfile);
            rmdir($dirfile);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'the post has been deleted');
    }
}
