<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\ResponseMessages;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserDash\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\User;
use App\Notifications\NewPostForAdminNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserPotsController extends Controller
{
    use ResponseMessages;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = auth('api')->user()->posts()->orderBy('created_at', 'Desc')->get();
        return $this->returnDate('my post', PostResource::collection($post) , 'success get my post');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->select('name')->get();
        return $this->returnDate('categories',$categories ,'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required', 'min:50'],
        ]);
        if ($validator->fails()){
            return $this->msgError($validator->errors(), 401);
        }
        $create_post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'comment_able' => $request->comment_able,
            'status' => $request->status,
            'user_id' =>\auth('api')->user()->id
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
        return $this->msgSuccess('success create post');
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
        $post =  Post::where('user_id', Auth::guard('api')-> id())->with('media')->find($id);
        $categories = Category::where('status',1)->select('name')->get();
        if ($post == null) {
            return $this->msgError('not Found', '404');
        }
        return $this->returnDate('data', ['edit post' => $post, 'categories' => $categories], 'success get edit post');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $my_post)
    {
        if (request('status') == 1) {
            Cache::forget('latest_posts');
        }
        $my_post->update(
            [
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'comment_able' => $request->comment_able,
                'status' => $request->status,
            ]
        );

        if ($request->post_media != null) {
            $i = 1;
            foreach ($request->post_media as $image_post) {
                $fileName = $my_post->slug . '-' . time() . '-' . $i . '.' .  $image_post->getClientOriginalExtension();
                $file_type = $image_post->getMimeType();
                $file_size = $image_post->getSize();
                $path = public_path('assest\posts\\' . $my_post->slug);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $path_image = $path . '\\' . $fileName;
                $file_image = 'assest/posts/' . $my_post->slug . '/' . $fileName;
                Image::make($image_post->getRealPath())->resize(1170, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(1170, 555, 0, 0)->save($path_image, 100);
                PostMedia::create([
                    'post_id' => $my_post->id,
                    'file_name' => $file_image,
                    'file_type' => $file_type,
                    'file_size' => $file_size,
                ]);
                $i++;
            }
        }
        return $this->msgSuccess('success update post');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $my_post)
    {
        if ($my_post->media->count() > 0) {
            foreach ($my_post->media as $images_deletes) {
                $dirfile = str_replace('/', '\\', public_path($images_deletes->file_name));
                unlink($dirfile);
            }
            $dirfile =  dirname($dirfile);
            rmdir($dirfile);
        }
        $my_post->delete();
        return $this->msgSuccess('the post has been deleted');
    }
}
