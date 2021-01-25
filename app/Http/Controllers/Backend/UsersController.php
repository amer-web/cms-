<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_user')->only('create');
        $this->middleware('permission:read_user')->only('index');
        $this->middleware('permission:update_user')->only('edit');
    }

    public function index()
    {
        $roles = Role::get();
        $users = User::orderBy('created_at', 'desc');
        if(request()->keywords != null)
        {
              $users = $users->search(request()->keywords, null, true);
        }
        if(request()->status != null)
        {
            $users = $users->where('status', request()->status);
        }
        if(request()->role != null)
        {
            $users = $users->whereRoleIs(request()->role);
        }

        $paginate = (isset(request()->paginate) && request()->paginate != null) ? request()->paginate : '10';
        $users = $users->paginate($paginate);
        return view('backend.users.index',compact('users', 'roles'));
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
    public function edit(User $user)
    {
        $roles = Role::select('name', 'id')-> get();
        $userEdit = $user;
        return view('backend.users.edit', compact('userEdit', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
       $user->update([
           'status' => $request->status
       ]);
       $user->syncRoles($request->role);
      return redirect(route('admin.users.index'))->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        if ($user->user_image != 'assest/users/user.png') {
               $dirfile = str_replace('/', '\\', public_path($user->user_image));
               unlink($dirfile);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'the user has been deleted');
    }
}
