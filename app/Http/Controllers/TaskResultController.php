<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckTasksResultsRequests;
use App\Http\Resources\TaskResourceCollection;
use App\Services\Contracts\TaskResultServiceInterface;

class TaskResultController extends Controller
{
    private $resultService;

    public function __construct(TaskResultServiceInterface $resultService)
    {
        $this->resultService = $resultService;
    }

    public function checkAllResults(CheckTasksResultsRequests $request){
        return new TaskResourceCollection(
            $this->resultService->checkAllResults()
        );
    }
}
