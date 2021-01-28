<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\User;
use App\Notifications\NewPostForAdminNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class DashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts =  Auth::user()->posts()->with(['category', 'media',])->withCount('comments')->where('post_type', 'post')->orderBy('created_at', 'desc')->paginate(6);
        return view('frontend.users.dashboard', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.users.createpost');
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
            'title' => $request->title,
            'summary' => $request->summary,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'comment_able' => $request->comment_able,
            'status' => $request->status,
            'user_id' => Auth::user()->id
        ]);
        $admins = User::whereRoleIs(['admin', 'editor'])->get();
        foreach($admins as $admin)
        {
            $admin->notify(new NewPostForAdminNotify($create_post));
        }
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
        if($request->status == 1)
        {
            return redirect(route('dashboard.index'))->with('success', 'Published successfully Subject Name: ' . $create_post->title);
        }
            return redirect(route('dashboard.index'))->with('success', 'Post Saved');
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
        $post =  Post::where('user_id', Auth::id())->with('media')->find($id);
        if ($post == null) {
            return redirect('dashboard');
        }
        return view('frontend.users.editpost', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $dashboard)
    {

        if (request('status') == 1) {
            Cache::forget('latest_posts');
        }
         $dashboard->update(
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
                $fileName = $dashboard->slug . '-' . time() . '-' . $i . '.' .  $image_post->getClientOriginalExtension();
                $file_type = $image_post->getMimeType();
                $file_size = $image_post->getSize();
                $path = public_path('assest\posts\\' . $dashboard->slug);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $path_image = $path . '\\' . $fileName;
                $file_image = 'assest/posts/' . $dashboard->slug . '/' . $fileName;
                Image::make($image_post->getRealPath())->resize(1170, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(1170, 555, 0, 0)->save($path_image, 100);
                PostMedia::create([
                    'post_id' => $dashboard->id,
                    'file_name' => $file_image,
                    'file_type' => $file_type,
                    'file_size' => $file_size,
                ]);
                $i++;
            }
        }

        return redirect(route('dashboard.index'))->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $dashboard)
    {
        $dashboard->media;
        if ($dashboard->media->count() > 0) {
            foreach ($dashboard->media as $images_deletes) {
                $dirfile = str_replace('/', '\\', public_path($images_deletes->file_name));
                unlink($dirfile);
            }
            $dirfile = dirname($dirfile);
            rmdir($dirfile);
        }
        $dashboard->comments()->delete();
        $dashboard->delete();
        Cache::forget('latest_comments');
        Cache::forget('latest_posts');
        return back()->with('success', 'the post has been deleted');
    }

    public function destory_image($id_dele)
    {
        $media = PostMedia::find($id_dele);
        if(File::exists(public_path($media->file_name)))
        {
            unlink(public_path($media->file_name));
        }
        if(count(scandir(dirname(public_path($media->file_name)))) == 2)
        {
            rmdir(dirname(public_path($media->file_name)));
        }
         $media->delete();
         return true;
    }
}
