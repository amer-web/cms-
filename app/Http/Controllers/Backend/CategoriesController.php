<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:create_category')->only('create');
        $this->middleware('permission:read_category')->only('index');
        $this->middleware('permission:update_category')->only('edit');
    }
    public function index()
    {
        $categories = Category::paginate(5);
        return view('backend.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $create_category =   Category::create([
            'name' => $request['name'],
            'status' => $request->status,

            ]);
           return redirect(route('admin.categories.index'))->with('success', 'Created successfully Category Name: ' . $create_category->name);

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
        $categoryEdit = Category::where('slug', $slug)->first();
        return view('backend.category.edit', compact('categoryEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Category $category)
    {
        if($request->status == 1)
        {
            Cache::forget('categories');
        }
        $category->update($request->all());
        return redirect(route('admin.categories.index'))->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        return view('frontend.index');
        if ($category->media_posts->count() > 0) {
            foreach ($category->media_posts as $images_deletes) {
                $dirfile = str_replace('/', '\\', public_path($images_deletes->file_name));
                unlink($dirfile);
            }

            $dirfile =  dirname($dirfile);
            rmdir($dirfile);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'the Category has been deleted');
    }

}
