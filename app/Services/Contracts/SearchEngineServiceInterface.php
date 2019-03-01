<?php


namespace App\Services\Contracts;


use Illuminate\Http\Request;

interface SearchEngineServiceInterface
{
    public function getSearchEnginesListByCountry(Request $request);
}