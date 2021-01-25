<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function admins()
    {
        $rolesAdmin = Role::whereNotIn('name',['user'])->pluck('name')->toArray();
        $authUser = Auth::id();
        $usersAdmins = User::whereRoleIs($rolesAdmin)->whereNotIn('id', [$authUser])->get();
        return response()->json($usersAdmins);
    }
}
