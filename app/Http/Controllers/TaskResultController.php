<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckTasksResultsRequests;
use App\Http\Resources\TaskResourceCollection;
use App\Services\Contracts\TaskResultServiceInterface;

/**
 * Class TaskResultController
 * @package App\Http\Controllers
 */
class TaskResultController extends Controller
{
    /**
     * @var TaskResultServiceInterface
     */
    private $resultService;

    /**
     * TaskResultController constructor.
     * @param TaskResultServiceInterface $resultService
     */
    public function __construct(TaskResultServiceInterface $resultService)
    {
        $this->resultService = $resultService;
    }

    /**
     * PUT new results into database for inactive tasks
     *
     * @param CheckTasksResultsRequests $request
     * @return TaskResourceCollection
     */
    public function checkAllResults(CheckTasksResultsRequests $request){
        return new TaskResourceCollection(
            $this->resultService->checkAllResults()
        );
    }
}
