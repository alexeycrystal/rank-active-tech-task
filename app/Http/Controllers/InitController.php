<?php

namespace App\Http\Controllers;


class InitController extends Controller
{
    public function init(){
        return view()->make('welcome');
    }
}
