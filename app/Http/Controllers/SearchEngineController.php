<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowSearchEnginesRequest;
use App\Services\Contracts\SearchEngineServiceInterface;

/**
 * Class SearchEngineController
 * @package App\Http\Controllers
 */
class SearchEngineController extends Controller
{
    /**
     * @var SearchEngineServiceInterface
     */
    private $engineService;

    /**
     * SearchEngineController constructor.
     * @param SearchEngineServiceInterface $engineService
     */
    public function __construct(SearchEngineServiceInterface $engineService)
    {
        $this->engineService = $engineService;
    }

    /**
     * GET engines list
     *
     * @param ShowSearchEnginesRequest $request
     * @return mixed
     */
    public function index(ShowSearchEnginesRequest $request)
    {
        return $this->engineService
            ->getSearchEnginesListByCountry($request);
    }
}
