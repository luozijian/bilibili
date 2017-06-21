<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBarrageRequest;
use Illuminate\Http\Request;

class BarrageController extends Controller
{
    public function store(CreateBarrageRequest $request)
    {
        dd($request->all());
    }
}
