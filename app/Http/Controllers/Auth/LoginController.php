<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/pict-internal-admin-portal'; // Diarahkan ke dashboard admin

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware() DIHAPUS karena sudah tidak didukung di Laravel 13.
        // Middleware sudah ditangani dengan rapi oleh routes/web.php
    }
}