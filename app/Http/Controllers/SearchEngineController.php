<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowSearchEnginesRequest;
use App\Services\Contracts\SearchEngineServiceInterface;

class SearchEngineController extends Controller
{
    private $engineService;

    public function __construct(SearchEngineServiceInterface $engineService)
    {
        $this->engineService = $engineService;
    }

    public function index(ShowSearchEnginesRequest $request)
    {
        return $this->engineService
            ->getSearchEnginesListByCountry($request);
    }
}
