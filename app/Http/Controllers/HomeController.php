<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        return view('home');
    }

    public function getCsrfField()
    {
        return [
            'error_code' => 0,
            'error_msg' => 'success',
            'result' => csrf_token()
        ];
    }

    public function getLoginStatus()
    {
        if (Auth::check()) {
            return [
                'error_code' => 0,
                'error_msg' => 'success',
                'result' => [
                    'login' => 1,
                    'nickname' => Auth::user()->name,
                ]
            ];
        }
        return [
            'error_code' => 0,
            'error_msg' => 'success',
            'result' => [
                'login' => 0
            ]
        ];
    }
}
