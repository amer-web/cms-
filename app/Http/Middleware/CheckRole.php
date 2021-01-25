<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = Role::select('name')->whereNotIn('name', ['user'])->pluck('name')->toArray();
        if(auth()->user()->hasRole($roles)){
            return $next($request);
        }
        return redirect(url('/404'));
    }
}
