<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    // public function handle(Request $request, Closure $next, $role = ''): Response
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        // ------------------------------------- *jobsheet 07* -------------------------------------
        // -- JS7 - P2(3) --
        //ambil data user yang login
        // $user = $request->user();       //fungsi user() diambil dari UserModel.php

        // if ($user->hasRole($role)) {    //cek apakah user punya role yang diinginkan
        //     return $next($request);
        // }

        // -- JS7 - P3(2) --
        $user_role = $request->user()->getRole();       //ambil data level_kode dari user yang login

        if (in_array($user_role, $roles)) {     //cek apakah kode level_kode user ada di dalam array roles
            return $next($request);     //jika ada, maka lanjutkan request
        }

        //jika tidak punya role, maka tampilkan error 403
        abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
    }
}