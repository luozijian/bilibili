<?php

namespace App\Http\Controllers;

use App\Events\FirstLogin;
use App\Models\Subtitle;
use Codeception\Module\Db;
use Illuminate\Http\Request;
use Mockery\Exception;

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

        \DB::statement('CREATE DATABASE if not exists exam_07');

        dd(1);
        event(new FirstLogin());

        return view('home');
    }
}
