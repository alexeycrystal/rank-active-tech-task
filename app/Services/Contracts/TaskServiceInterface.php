<?php

namespace App\Services\Contracts;


use Illuminate\Http\Request;

interface TaskServiceInterface
{
    public function create(Request $request);

    public function getAll(Request $request);
}