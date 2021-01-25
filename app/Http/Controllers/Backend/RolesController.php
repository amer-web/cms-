<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_role')->only('create');
        $this->middleware('permission:read_role')->only('index');
        $this->middleware('permission:update_role')->only('edit');
    }

    public function index()
    {

       $roles = Role::withCount('users')->get();
        return view('backend.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
       return view('backend.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'permission' => ['required','array', 'min:1']
        ]);
        $create_role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        $create_role->attachPermissions($request->permission);
        return redirect(route('admin.roles.index'))->with('success', 'Create Role Done');
    }

    /**
     * Display the specified resource.
    */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('backend.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Role $role
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,Role $role)
    {
        if ($role->name != 'admin' && $role->name != 'user')
        {
            $this->validate($request, [
                'permission' => ['required','array', 'min:1']
            ]);
             $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
             ]);
            $role->syncPermissions($request->permission);
        } else {
            $role->update([
                'display_name' => $request->display_name,
                'description' => $request->description,
             ]);
        }
        return redirect(route('admin.roles.index'))->with('success', 'Role Updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $users = User::whereRoleIs([$role->name])->get();
        if($users->count() > 0 ){
           foreach ($users as $user)
            {
                $user->attachRole('user');
            }
        }
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'the role has been deleted');
    }
}
