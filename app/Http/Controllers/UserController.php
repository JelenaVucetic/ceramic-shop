<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =  User::orderBy('created_at', 'desc')->select( 'name', 'last_name', 'email', 'password', 'date_of_birth', 'address', 'city', 'country', 'phone', 'is_admin')->get();
        return view('admin.add_user', ["users" => $users]);
    }
}
